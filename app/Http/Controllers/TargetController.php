<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Demo;
use App\Models\Maintenance;
use App\Models\Mapping;
use App\Models\Sale;
use App\Models\Target;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\TargetMetric;
use Illuminate\Support\Facades\DB;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::where('user_id', auth()->user()->id)->get();

        return response()->json(['data' => $targets], 200);
    }

    public function store(Request $request)
    {
        $target = Target::create([
            'user_id' => $request->user_id,
            'target_number_of_visits' => $request->target_number_of_visits,
            'target_start_date' => $request->target_start_date,
            'target_end_date' => $request->target_end_date,
        ]);

        if (!$target) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }

        return response()->json(['data' => $target, 'message' => 'Target created successfully'], 201);
    }

    public function showAllTargets(Request $request)
    {
        //if the metric_name is just empty, get the first metric if it exists
        if ($request->metric_name == null) {
            $metric = TargetMetric::first();
            if ($metric) {
                $request->metric_name = $metric->name;
            } else {
                return response()->json(
                    [
                        'message' => 'No targets found',
                        'data' => [],
                    ],
                    200
                );
            }
        }

        // Get all targets with their users and metrics filtered by the specified metric name
        $targets = Target::with([
            'users',
            'targetMetrics' => function ($query) use ($request) {
                $query->where('name', $request->metric_name);
            }
        ])->get();

        // Transform the data for simplification
        $transformedTargets = $targets->map(function ($target) {
            // Check if targetMetrics is not null
            if ($target->targetMetrics) {
                //actual value is calculated based on the metric name and user id
                $actual_value = $this->calculateActualValue($target->targetMetrics->name, $target->user_id);
                // Calculate the percentage of target covered
                $percentageCovered = ($actual_value / ($target->targetMetrics->target_value)) * 100;

                // Calculate the days remaining/hours to the deadline
                $now = Carbon::now();
                $deadline = Carbon::parse($target->targetMetrics->deadline);
                $timeRemaining = $now->diffForHumans($deadline, true);

                return [
                    'id' => $target->id,
                    'user_name' => $target->users->name,
                    'user_email' => $target->users->email,
                    'target_metric_name' => $target->targetMetrics->name,
                    'percentage_covered' => round($percentageCovered),
                    'actual_value' => $actual_value,
                    'target_value' => $target->targetMetrics->target_value,
                    'time_remaining' => $timeRemaining,
                ];
            } else {
                // Handle the case where targetMetrics is null
                return null;
            }
        })->filter(); // Remove null values from the resulting array

        // Use values() to reindex the array and remove numeric keys
        $transformedTargets = $transformedTargets->values()->all();

        return response()->json(
            [
                'message' => 'Targets retrieved successfully',
                'data' => $transformedTargets,
            ],
            200
        );
    }

    public function calculateActualValue($metric_name, $user_id)
    {
        /**check the target metric, if its product, then get actual value from the count of sales made by the user,
         * if its mapping, get the actual value from the count of mappings made by the user
         * if maintenance, get the actual value from the count of maintenance made by the user
         * if delivery, get the actual value from the count of deliveries made by the user
         * if demo, get the actual value from the count of demos made by the user
         */
        $actual_value = 0;
        if ($metric_name == 'product') {
            $actual_value = DB::table('sales')
                ->join('sale_products', 'sales.id', '=', 'sale_products.sale_id')
                ->where('sales.user_id', $user_id)
                ->sum('sale_products.quantity');
        } elseif ($metric_name == 'mapping') {
            $actual_value = Mapping::where('user_id', $user_id)->count();
        } elseif ($metric_name == 'maintenance') {
            $actual_value = Maintenance::where('user_id', $user_id)->count();
        } elseif ($metric_name == 'delivery') {
            $actual_value = Delivery::where('user_id', $user_id)->count();
        } elseif ($metric_name == 'demo') {
            $actual_value = Demo::where('user_id', $user_id)->count();
        }

        return $actual_value;
    }

    public function getUsersWithTarget(Request $request)
    {
        if ($request->metric_name == null) {
            $metric = TargetMetric::first();
            if ($metric) {
                $request->metric_name = $metric->name;
            } else {
                return response()->json(
                    [
                        'message' => 'No targets found',
                        'data' => [],
                    ],
                    200
                );
            }
        }

        // Get the id of the metric
        $metric_id = TargetMetric::where('name', $request->metric_name)->value('id');

        // Get users with targets for the specified metric
        $users = User::where('id', '!=', auth()->user()->id)
            ->with([
                'targets' => function ($query) use ($metric_id) {
                    $query->where('target_metrics_id', $metric_id);
                }
            ])
            ->get()
            ->map(function ($user) {
                $user->assigned_target = $user->targets->isNotEmpty();
                return $user->only(['id', 'name', 'email', 'assigned_target']);
            });

        return response()->json(
            [
                'message' => 'Users retrieved successfully',
                'data' => $users
            ],
            200
        );
    }

    public function assignTargets(Request $request)
    {
        if ($request->metric_name == null) {
            $metric = TargetMetric::first();
            if ($metric) {
                $request->metric_name = $metric->name;
            } else {
                return response()->json(
                    [
                        'message' => 'No targets found',
                        'data' => [],
                    ],
                    200
                );
            }
        }
        // Get the id of the metric
        $metric_id = TargetMetric::where('name', $request->metric_name)->value('id');

        // Get the array of user ids from the request
        $user_ids = $request->user_ids;

        foreach ($user_ids as $key => $value) {
            Target::create([
                'user_id' => $value,
                'target_metrics_id' => $metric_id,
            ]);
        }

        return response()->json(
            [
                'message' => 'Targets assigned successfully'
            ],
            200
        );
    }
}
