<?php

namespace App\Http\Controllers;

use App\Models\JawabanReview;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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


    public function store(Request $request)
    {
        $request->validate([
            'jawaban_id'    => 'required|exists:jawabans,id',
            'review'        => 'required|string',
            'nilai'         => 'required|integer|min:0|max:100',
            'file_feedback' => 'nullable|file|mimes:pdf,doc,docx,zip,jpg,png|max:2048',
        ]);

        $filename = null;

        if ($request->hasFile('file_feedback')) {
            $file = $request->file('file_feedback');
            $ext = $file->getClientOriginalExtension();
            $filename = 'feedback_' . Str::random(10) . '.' . $ext;

            $file->move(public_path('feedback'), $filename);
        }

        JawabanReview::create([
            'jawaban_id'    => $request->jawaban_id,
            'review'        => $request->review,
            'nilai'         => $request->nilai,
            'file_feedback' => $filename,
        ]);

        return redirect()->back()->with('success', 'Review berhasil disimpan.');
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
