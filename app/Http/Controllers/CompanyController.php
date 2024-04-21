<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CompanyRepository;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * @var CompanyRepository
     */
    protected $companyRepository;

    public function __construct()
    {
        $this->companyRepository = new CompanyRepository();
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = $this->companyRepository->getAll();
        return view('company.index', compact('companies'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('company.create');
    }

    /**
     * @param  \Illuminate\Http\CompanyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        $this->companyRepository->create($request->toArray());
        return redirect()->route('company.index')->with('message', '企業を登録しました');
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
