<?php

namespace App\Http\Controllers;

use App\Note;
use App\Classes\Notes;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $program = $request->program;
        $notes = Note::groupBy('key')
            ->groupBy('value')
            ->groupBy('channel');
        if ($program) {
            $notes = $notes->where('value', $program);
        }
        $notes = $notes->get();
        return $notes;
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
        $note = $this->validateNote();
        $stored = Note::create($note);
        return $stored;
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
    public function update(Note $note)
    {
        $note->update($this->validateNote());
        return $note;  
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

    // Notes for a single program
    public function program($program, $channel = 'ADMA')
    {
        $notes = Note::where('value', $program)
            ->where('channel', $channel)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return $notes;
    }
    
    // Notes for a single channel
    public function channel(Request $request)
    {
        $channel = $request->input('channel', '');
        $location = $request->input('location', '');
        $program = $request->input('program', '');
        $array = $request->input('array', []);

        if ($channel == '' || $channel == null) {
            $channel = 'ADMA';
        }

        if ($program != '') {
            $programArray = [$program];
        }
        if ($array != []) {
            $programArray = $array;
        }

        // For ADMA Notes, of no location set, get locations
        if ($channel == 'ADMA' && $location == '') {
            $programArray = ['Orlando', 'Toronto', 'Chicago', 'Chandler', 'ASU', 'MVU'];
        }

        // Last Calendar Year
        $date = new \DateTime();
        $date->modify('-1 year');
        $yearAgo = $date->format('Y-m-d H:i:s');

        $notes = Note::whereIn('program', $programArray)
            ->where('channel', $channel)
            ->where('date_created', '>', $yearAgo)
            ->groupBy('program')
            ->groupBy('date_created')
            ->get();
        $returnArray = [];
        foreach ($notes as $note) {
            $returnArray[$note->program] = $note;
        }
        return $returnArray;
    }

    public function validateNote()
    {
        return request()->validate([
            'id' => '',
            'user_id' => '',
            'type' => '',
            'key' => '',
            'value' => '',
            'channel' => '',
            'content' => ''
        ]);
    }
}
