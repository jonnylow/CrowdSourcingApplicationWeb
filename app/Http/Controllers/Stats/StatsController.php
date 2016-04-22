<?php

namespace App\Http\Controllers\Stats;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Activity;
use App\Centre;
use Carbon\Carbon;
use Auth;
use DB;
use View;

/**
 * Resource controller that handles the logic when managing statistics.
 *
 * @package App\Http\Controllers\Stats
 */
class StatsController extends Controller
{
    /**
     * Show the general statistics page for all branches/centres.
     * Responds to requests to GET /stats
     *
     * @return Response
     */
    public function index()
    {
        $centreList = Auth::user()->centres;
        $centreActivities = Centre::with('activities')
            ->whereIn('centre_id', Auth::user()->centres->lists('centre_id'))->get()
            ->sortBy('name');

        $centreList = $centreList->lists('name', 'centre_id')->sort()->prepend('All', 'all')->toArray();

        return view('stats.index', compact('centreActivities', 'centreList'));
    }

    /**
     * Get the main chart (left) for the given branch/centre.
     * Responds to requests to GET /stats/getMainCharts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function ajaxRetrieveMainCharts(Request $request) {
        $charts = array();

        array_set($charts, 'options.title.display', true);
        array_set($charts, 'options.title.fontFamily', 'Lato');
        array_set($charts, 'options.title.fontSize', 20);
        array_set($charts, 'options.legend.labels.fontFamily', 'Lato');
        array_set($charts, 'options.legend.labels.fontSize', 16);

        $centre = $request->get('centre');
        $centreList = Auth::user()->centres;

        if($centre == 'all') {
            $labels = $centreList->sortBy('name')->lists('name');

            $datasets = array();

            $activityCount = Activity::with('centre')->withTrashed()
                ->select('centre_id', DB::raw('count(*) as total'))
                ->WhereIn('centre_id', $centreList->lists('centre_id'))
                ->groupBy('centre_id')->get()
                ->sortBy('centre.name')
                ->lists('total')
                ->transform(function ($item) {
                    return intval($item);
                });

            array_set($charts, 'type', 'doughnut');
            array_set($charts, 'options.cutoutPercentage', 30);
            array_set($charts, 'options.title.text', 'Total Number of Activities per Centres');
            array_set($charts, 'options.animation.animateScale', true);
            array_set($charts, 'data.labels', $labels);
            array_set($datasets, 'data', $activityCount);

            $backgroundColor = array('#729ece', '#ff9e4a', '#67bf5c', '#ed665d',
                '#ad8bc9', '#a8786e', '#ed97ca', '#cdcc5d', '#6dccda', '#a2a2a2');
            $hoverBackgroundColor = array('#aec7e8', '#ffbb78', '#98df8a', '#ff9896',
                '#c5b0d5', '#c49c94', '#f7b6d2', '#dbdb8d', '#9edae5', '#c7c7c7');
            array_set($datasets, 'backgroundColor', $backgroundColor);
            array_set($datasets, 'hoverBackgroundColor', $hoverBackgroundColor);

            array_set($charts, 'data.datasets', array($datasets));
        } else {
            $labels = array(Carbon::now()->subMonth(5)->format('F'), Carbon::now()->subMonth(4)->format('F'),
                Carbon::now()->subMonth(3)->format('F'), Carbon::now()->subMonth(2)->format('F'),
                Carbon::now()->subMonth(1)->format('F'), Carbon::now()->format('F'));

            $activityDataset = array('label' => 'Activities completed',
                'backgroundColor'=> '#729ece', 'borderWidth' => 1,
                'hoverBackgroundColor' => '#aec7e8');

            $activityFiveMthAgo = Activity::ofCentre($centre)->completed()->subMonth(5)->get();
            $activityFourMthAgo = Activity::ofCentre($centre)->completed()->subMonth(4)->get();
            $activityThreeMthAgo = Activity::ofCentre($centre)->completed()->subMonth(3)->get();
            $activityTwoMthAgo = Activity::ofCentre($centre)->completed()->subMonth(2)->get();
            $activityOneMthAgo = Activity::ofCentre($centre)->completed()->subMonth(1)->get();
            $activityThisMth = Activity::ofCentre($centre)->completed()->subMonth(0)->get();
            $activityCount = array($activityFiveMthAgo->count(), $activityFourMthAgo->count(),
                $activityThreeMthAgo->count(), $activityTwoMthAgo->count(),
                $activityOneMthAgo->count(), $activityThisMth->count());

            array_set($activityDataset, 'data', $activityCount);

            $volunteerDataset = array('label' => 'Unique Volunteers volunteered',
                'backgroundColor'=> '#ff9e4a', 'borderWidth' => 1,
                'hoverBackgroundColor' => '#ffbb78');

            $volunteerFiveMthAgo = array_unique(Activity::ofCentre($centre)
                ->completed()->subMonth(5)->lists('volunteer_id')->toArray());
            $volunteerFourMthAgo = array_unique(Activity::ofCentre($centre)
                ->completed()->subMonth(4)->lists('volunteer_id')->toArray());
            $volunteerThreeMthAgo = array_unique(Activity::ofCentre($centre)
                ->completed()->subMonth(3)->lists('volunteer_id')->toArray());
            $volunteerTwoMthAgo = array_unique(Activity::ofCentre($centre)
                ->completed()->subMonth(2)->lists('volunteer_id')->toArray());
            $volunteerOneMthAgo = array_unique(Activity::ofCentre($centre)
                ->completed()->subMonth(1)->lists('volunteer_id')->toArray());
            $volunteerThisMth = array_unique(Activity::ofCentre($centre)
                ->completed()->subMonth(0)->lists('volunteer_id')->toArray());
            $volunteerCount = array(count($volunteerFiveMthAgo), count($volunteerFourMthAgo),
                count($volunteerThreeMthAgo), count($volunteerTwoMthAgo),
                count($volunteerOneMthAgo), count($volunteerThisMth));

            array_set($volunteerDataset, 'data', $volunteerCount);

            array_set($charts, 'type', 'bar');
            array_set($charts, 'options.title.text', 'Records for Past 6 Months');

            $scaleLabel = array('display' => true, 'fontFamily' => 'Lato', 'fontSize' => 16);
            $xTicks = array('fontFamily' => 'Lato', 'fontSize' => 16);
            $yTicks = array('fontFamily' => 'Lato', 'fontSize' => 16, 'maxTicksLimit' => 6, 'min' => 0, 'suggestedMax' => 15);
            array_set($charts, 'options.scales.xAxes', array(['position' => 'top', 'scaleLabel' => $scaleLabel, 'ticks' => $xTicks]));
            array_set($charts, 'options.scales.yAxes', array(['scaleLabel' => $scaleLabel, 'ticks' => $yTicks]));

            array_set($charts, 'data.labels', $labels);
            array_set($charts, 'data.datasets', array($activityDataset, $volunteerDataset));
        }

        return json_encode($charts);
    }

    /**
     * Get the sub chart (right) for the given branch/centre.
     * Responds to requests to GET /stats/getSubCharts
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function ajaxRetrieveSubCharts(Request $request) {
        $charts = array();

        $centre = $request->get('centre');
        if($centre == 'all') {
            $centreActivities = Centre::with('activities')
                ->whereIn('centre_id', Auth::user()->centres->lists('centre_id'))->get()
                ->sortBy('name');

            $html = View::make('stats._centresTable', compact('centreActivities'))->render();
            $charts['html'] = $html;
        } else {
            $unfilled = Activity::ofCentre($centre)->unfilled()->get();
            $urgent = Activity::ofCentre($centre)->urgent()->get();
            $awaitingApproval = Activity::ofCentre($centre)->awaitingApproval()->get();
            $approved = Activity::ofCentre($centre)->approved()->get();

            $html = View::make('stats._centreTable', compact('unfilled', 'urgent', 'awaitingApproval', 'approved'))->render();
            $charts['html'] = $html;
        }

        return json_encode($charts);
    }
}
