<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\News;
use App\Models\Recruitment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $events = [];

        $news = News::where('user_id', Auth::user()->id)
            ->where('read', 0)
            ->get();

        if(Auth::user()->role == 'producer') {
            $recruitments = Recruitment::where('producer_id', Auth::user()->id)
                ->get();
            foreach ($recruitments as $recruitment) {
                if($recruitment['status'] == 'draft') {
                    $color = '#b61889';
                    $url = url('dashboard/producer/recruitments/'.$recruitment['id'].'/edit');
                }
                elseif($recruitment['status'] == 'collecting') {
                    $color = '#e80553';
                    $url = route('recruitment_applicants_view', ['recruitment_id' => $recruitment['id']]);
                }
                elseif($recruitment['status'] == 'working') {
                    $color = '#172a89';
                    $url = route('recruitment_review_view', ['recruitment_id' => $recruitment['id']]);
                }
                else {
                    $color = '#0b5306';
                    $url = route('recruitment_result_view', ['recruitment_id' => $recruitment['id']]);
                }
                array_push($events, [
                    "title" => $recruitment['title'],
                    "start" => $recruitment['work_date_start'],
                    "end" => $recruitment['work_date_end'],
                    "color" => $color,
                    "url" => $url
                ]);
            }
        }
        else {
            $recruitments = Applicant::join('_recruitments', '_recruitments.id', '=', '_applicants.recruitment_id')
                ->select('_applicants.id as applicant_id', '_applicants.status as applicant_status', '_recruitments.status as recruitment_status', '_applicants.*', '_recruitments.*')
                ->where('_applicants.worker_id', Auth::user()->id)
                ->get();

            foreach ($recruitments as $recruitment) {
                $url = route('applications_view');
                if($recruitment['applicant_status'] == 'waiting') {
                    $color = '#8058ef';
                }
                elseif($recruitment['applicant_status'] == 'approved') {
                    $color = '#069367';
                }
                elseif($recruitment['applicant_status'] == 'rejected') {
                    $color = '#fd8503';
                }
                elseif($recruitment['applicant_status'] == 'abandoned') {
                    $color = '#219ff3';
                }
                elseif($recruitment['applicant_status'] == 'fired') {
                    $color = '#90ac11';
                }
                else {
                    $color = '#ac3d11';
                }
                array_push($events, [
                    "title" => $recruitment['title'],
                    "start" => $recruitment['work_date_start'],
                    "end" => $recruitment['work_date_end'],
                    "color" => $color,
                    "url" => $url
                ]);
            }
        }

        return view('dashboard', ['events' => $events, 'news' => $news]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
