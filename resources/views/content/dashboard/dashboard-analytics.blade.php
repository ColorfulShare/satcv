@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
<!-- vendor css files -->
{{-- <link rel="stylesheet" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('/fonts/font-awesome/css/font-awesome.min.css')}}"> --}}
@endsection
@section('page-style')
<!-- Page css files -->
{{-- <link rel="stylesheet" href="{{ asset('css/base/plugins/charts/chart-apex.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/plugins/extensions/ext-component-toastr.css') }}">
<link rel="stylesheet" href="{{ asset('css/base/pages/app-invoice-list.css') }}"> --}}
@endsection

@section('content')
<!-- Dashboard Analytics Start -->
<section id="dashboard-analytics">


    <div class="row match-height justify-content-center">
        <div class="col-12">
            <div class="card-body">
                <div class="profile-image-wrapper">
                    <div class="profile-image text-center">
                        <div class="avatar">
                            <img src="http://127.0.0.1:8000/images/portrait/small/avatar-s-9.jpg" alt="Profile Picture">
                        </div>
                    </div>
                </div>
                <h3 class="text-center">Curtis Stone</h3>
                <h6 class="text-muted font-weight-bolder text-center">Bitcoin Ecuador ID <span>3683</span></h6>
                <h5 class="text-success font-weight-bolder text-center">Usuario Verificado</h5>

				<div class="row justify-content-center my-2">
					<div class="form-group col-8">
						<label for="basicSelect" class="d-flex justify-content-center">Seleccione un contrato para su información</label>
						<select class="form-control" id="basicSelect">
							<option>Contrato #: 3296 / 2020-11-04 a 2025-11-04</option>
							<option>Contrato #: 3297 / 2021-12-03 a 2026-12-03</option>
							<option>Contrato #: 3298 / 2022-08-21 a 2027-08-21</option>
						</select>
					</div>
				</div>
				

                <hr class="mb-2">

                <div class="d-flex justify-content-around align-items-center">
                    <div class="text-center">
                        <i class="fa fa-briefcase fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Inversión</h6>
                        <h3 class="mb-0">156</h3>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-wallet fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Saldo Capital</h6>
                        <h3 class="mb-0">324</h3>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-chart-line fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Productividad</h6>
                        <h3 class="mb-0">123</h3>
                    </div>
                    <div class="text-center">
                        <i class="fa fa-money-bill fa-3x"></i>
                        <h6 class="text-muted font-weight-bolder">Retirado</h6>
                        <h3 class="mb-0">400</h3>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-12 my-3">
            <div class="card">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                    <div class="card-header border-bottom p-1">
                        <div class="head-label">
                            <h6 class="mb-0 h2">Historial de Rendimiento</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mx-0 row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select
                                        name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                                        class="custom-select form-control">
                                        <option value="7">7</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="75">75</option>
                                        <option value="100">100</option>
                                    </select> entries</label></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input
                                        type="search" class="form-control" placeholder=""
                                        aria-controls="DataTables_Table_0"></label></div>
                        </div>
                    </div>
                    <table class="datatables-basic table dataTable no-footer dtr-column collapsed"
                        id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info"
                        style="width: 1050px;">
                        <thead>
                            <tr role="row">
                                <th class="control sorting_disabled" rowspan="1" colspan="1" style="width: 0px;"
                                    aria-label=""></th>
                                
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 246px;"
                                    aria-label="Name: activate to sort column ascending">Name</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 237px;"
                                    aria-label="Email: activate to sort column ascending">Email</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 66px;"
                                    aria-label="Date: activate to sort column ascending">Date</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 62px;"
                                    aria-label="Salary: activate to sort column ascending">Salary</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                    colspan="1" style="width: 82px;"
                                    aria-label="Status: activate to sort column ascending">Status</th>
                                <th class="sorting_disabled" rowspan="1" colspan="1" style="width: 0px; display: none;"
                                    aria-label="Actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd">
                                <td class=" control" tabindex="0" style=""></td>
                                <td>
                                    <div class="d-flex justify-content-left align-items-center">
                                        <div class="avatar  bg-light-warning  mr-1"><span
                                                class="avatar-content">GG</span></div>
                                        <div class="d-flex flex-column"><span
                                                class="emp_name text-truncate font-weight-bold">Glyn
                                                Giacoppo</span><small class="emp_post text-truncate text-muted">Software
                                                Test Engineer</small></div>
                                    </div>
                                </td>
                                <td>ggiacoppo2r@apache.org</td>
                                <td>04/15/2017</td>
                                <td>$24973.48</td>
                                <td><span class="badge badge-pill  badge-light-success">Professional</span></td>
                                <td style="display: none;">
                                    <div class="d-inline-flex"><a class="pr-1 dropdown-toggle hide-arrow text-primary"
                                            data-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical font-small-4">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg></a>
                                        <div class="dropdown-menu dropdown-menu-right"><a href="javascript:;"
                                                class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-file-text font-small-4 mr-50">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                    </path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                </svg>Details</a><a href="javascript:;" class="dropdown-item"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-archive font-small-4 mr-50">
                                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                                    <rect x="1" y="3" width="22" height="5"></rect>
                                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                                </svg>Archive</a><a href="javascript:;"
                                                class="dropdown-item delete-record"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2 font-small-4 mr-50">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>Delete</a></div>
                                    </div><a href="javascript:;" class="item-edit"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit font-small-4">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg></a>
                                </td>
                            </tr>
                            <tr class="even">
                                <td class=" control" tabindex="0" style=""></td>
                                <td>
                                    <div class="d-flex justify-content-left align-items-center">
                                        <div class="avatar  mr-1"><img
                                                src="http://127.0.0.1:8000/images/avatars/10-small.png" alt="Avatar"
                                                width="32" height="32"></div>
                                        <div class="d-flex flex-column"><span
                                                class="emp_name text-truncate font-weight-bold">Evangelina
                                                Carnock</span><small class="emp_post text-truncate text-muted">Cost
                                                Accountant</small></div>
                                    </div>
                                </td>
                                <td>ecarnock2q@washington.edu</td>
                                <td>01/26/2017</td>
                                <td>$23704.82</td>
                                <td><span class="badge badge-pill  badge-light-warning">Resigned</span></td>
                                <td style="display: none;">
                                    <div class="d-inline-flex"><a class="pr-1 dropdown-toggle hide-arrow text-primary"
                                            data-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical font-small-4">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg></a>
                                        <div class="dropdown-menu dropdown-menu-right"><a href="javascript:;"
                                                class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-file-text font-small-4 mr-50">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                    </path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                </svg>Details</a><a href="javascript:;" class="dropdown-item"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-archive font-small-4 mr-50">
                                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                                    <rect x="1" y="3" width="22" height="5"></rect>
                                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                                </svg>Archive</a><a href="javascript:;"
                                                class="dropdown-item delete-record"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2 font-small-4 mr-50">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>Delete</a></div>
                                    </div><a href="javascript:;" class="item-edit"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit font-small-4">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg></a>
                                </td>
                            </tr>
                            <tr class="odd">
                                <td class=" control" tabindex="0" style=""></td>
                                
                                <td>
                                    <div class="d-flex justify-content-left align-items-center">
                                        <div class="avatar  mr-1"><img
                                                src="http://127.0.0.1:8000/images/avatars/7-small.png" alt="Avatar"
                                                width="32" height="32"></div>
                                        <div class="d-flex flex-column"><span
                                                class="emp_name text-truncate font-weight-bold">Olivette
                                                Gudgin</span><small
                                                class="emp_post text-truncate text-muted">Paralegal</small></div>
                                    </div>
                                </td>
                                <td>ogudgin2p@gizmodo.com</td>
                                <td>04/09/2019</td>
                                <td>$15211.60</td>
                                <td><span class="badge badge-pill  badge-light-success">Professional</span></td>
                                <td style="display: none;">
                                    <div class="d-inline-flex"><a class="pr-1 dropdown-toggle hide-arrow text-primary"
                                            data-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical font-small-4">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg></a>
                                        <div class="dropdown-menu dropdown-menu-right"><a href="javascript:;"
                                                class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-file-text font-small-4 mr-50">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                    </path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                </svg>Details</a><a href="javascript:;" class="dropdown-item"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-archive font-small-4 mr-50">
                                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                                    <rect x="1" y="3" width="22" height="5"></rect>
                                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                                </svg>Archive</a><a href="javascript:;"
                                                class="dropdown-item delete-record"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2 font-small-4 mr-50">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>Delete</a></div>
                                    </div><a href="javascript:;" class="item-edit"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit font-small-4">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg></a>
                                </td>
                            </tr>
                            <tr class="even">
                                <td class=" control" tabindex="0" style=""></td>
                                
                                <td>
                                    <div class="d-flex justify-content-left align-items-center">
                                        <div class="avatar  bg-light-dark  mr-1"><span class="avatar-content">RP</span>
                                        </div>
                                        <div class="d-flex flex-column"><span
                                                class="emp_name text-truncate font-weight-bold">Reina
                                                Peckett</span><small class="emp_post text-truncate text-muted">Quality
                                                Control Specialist</small></div>
                                    </div>
                                </td>
                                <td>rpeckett2o@timesonline.co.uk</td>
                                <td>05/20/2018</td>
                                <td>$16619.40</td>
                                <td><span class="badge badge-pill  badge-light-warning">Resigned</span></td>
                                <td style="display: none;">
                                    <div class="d-inline-flex"><a class="pr-1 dropdown-toggle hide-arrow text-primary"
                                            data-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical font-small-4">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg></a>
                                        <div class="dropdown-menu dropdown-menu-right"><a href="javascript:;"
                                                class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-file-text font-small-4 mr-50">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                    </path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                </svg>Details</a><a href="javascript:;" class="dropdown-item"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-archive font-small-4 mr-50">
                                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                                    <rect x="1" y="3" width="22" height="5"></rect>
                                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                                </svg>Archive</a><a href="javascript:;"
                                                class="dropdown-item delete-record"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2 font-small-4 mr-50">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>Delete</a></div>
                                    </div><a href="javascript:;" class="item-edit"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit font-small-4">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg></a>
                                </td>
                            </tr>
                            <tr class="odd">
                                <td class=" control" tabindex="0" style=""></td>
                                
                                <td>
                                    <div class="d-flex justify-content-left align-items-center">
                                        <div class="avatar  bg-light-dark  mr-1"><span class="avatar-content">AB</span>
                                        </div>
                                        <div class="d-flex flex-column"><span
                                                class="emp_name text-truncate font-weight-bold">Alaric
                                                Beslier</span><small class="emp_post text-truncate text-muted">Tax
                                                Accountant</small></div>
                                    </div>
                                </td>
                                <td>abeslier2n@zimbio.com</td>
                                <td>04/16/2017</td>
                                <td>$19366.53</td>
                                <td><span class="badge badge-pill  badge-light-warning">Resigned</span></td>
                                <td style="display: none;">
                                    <div class="d-inline-flex"><a class="pr-1 dropdown-toggle hide-arrow text-primary"
                                            data-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical font-small-4">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg></a>
                                        <div class="dropdown-menu dropdown-menu-right"><a href="javascript:;"
                                                class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-file-text font-small-4 mr-50">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                    </path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                </svg>Details</a><a href="javascript:;" class="dropdown-item"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-archive font-small-4 mr-50">
                                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                                    <rect x="1" y="3" width="22" height="5"></rect>
                                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                                </svg>Archive</a><a href="javascript:;"
                                                class="dropdown-item delete-record"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2 font-small-4 mr-50">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>Delete</a></div>
                                    </div><a href="javascript:;" class="item-edit"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit font-small-4">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg></a>
                                </td>
                            </tr>
                            <tr class="even">
                                <td class=" control" tabindex="0" style=""></td>
                                
                                <td>
                                    <div class="d-flex justify-content-left align-items-center">
                                        <div class="avatar  mr-1"><img
                                                src="http://127.0.0.1:8000/images/avatars/2-small.png" alt="Avatar"
                                                width="32" height="32"></div>
                                        <div class="d-flex flex-column"><span
                                                class="emp_name text-truncate font-weight-bold">Edwina
                                                Ebsworth</span><small class="emp_post text-truncate text-muted">Human
                                                Resources Assistant</small></div>
                                    </div>
                                </td>
                                <td>eebsworth2m@sbwire.com</td>
                                <td>09/27/2018</td>
                                <td>$19586.23</td>
                                <td><span class="badge badge-pill badge-light-primary">Current</span></td>
                                <td style="display: none;">
                                    <div class="d-inline-flex"><a class="pr-1 dropdown-toggle hide-arrow text-primary"
                                            data-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical font-small-4">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg></a>
                                        <div class="dropdown-menu dropdown-menu-right"><a href="javascript:;"
                                                class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-file-text font-small-4 mr-50">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                    </path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                </svg>Details</a><a href="javascript:;" class="dropdown-item"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-archive font-small-4 mr-50">
                                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                                    <rect x="1" y="3" width="22" height="5"></rect>
                                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                                </svg>Archive</a><a href="javascript:;"
                                                class="dropdown-item delete-record"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2 font-small-4 mr-50">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>Delete</a></div>
                                    </div><a href="javascript:;" class="item-edit"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit font-small-4">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg></a>
                                </td>
                            </tr>
                            <tr class="odd">
                                <td class=" control" tabindex="0" style=""></td>
                                
                                <td>
                                    <div class="d-flex justify-content-left align-items-center">
                                        <div class="avatar  bg-light-dark  mr-1"><span class="avatar-content">RH</span>
                                        </div>
                                        <div class="d-flex flex-column"><span
                                                class="emp_name text-truncate font-weight-bold">Ronica
                                                Hasted</span><small class="emp_post text-truncate text-muted">Software
                                                Consultant</small></div>
                                    </div>
                                </td>
                                <td>rhasted2l@hexun.com</td>
                                <td>07/04/2019</td>
                                <td>$24866.66</td>
                                <td><span class="badge badge-pill  badge-light-warning">Resigned</span></td>
                                <td style="display: none;">
                                    <div class="d-inline-flex"><a class="pr-1 dropdown-toggle hide-arrow text-primary"
                                            data-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-more-vertical font-small-4">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="12" cy="5" r="1"></circle>
                                                <circle cx="12" cy="19" r="1"></circle>
                                            </svg></a>
                                        <div class="dropdown-menu dropdown-menu-right"><a href="javascript:;"
                                                class="dropdown-item"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-file-text font-small-4 mr-50">
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z">
                                                    </path>
                                                    <polyline points="14 2 14 8 20 8"></polyline>
                                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                                    <polyline points="10 9 9 9 8 9"></polyline>
                                                </svg>Details</a><a href="javascript:;" class="dropdown-item"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-archive font-small-4 mr-50">
                                                    <polyline points="21 8 21 21 3 21 3 8"></polyline>
                                                    <rect x="1" y="3" width="22" height="5"></rect>
                                                    <line x1="10" y1="12" x2="14" y2="12"></line>
                                                </svg>Archive</a><a href="javascript:;"
                                                class="dropdown-item delete-record"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-trash-2 font-small-4 mr-50">
                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                    <path
                                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                    </path>
                                                    <line x1="10" y1="11" x2="10" y2="17"></line>
                                                    <line x1="14" y1="11" x2="14" y2="17"></line>
                                                </svg>Delete</a></div>
                                    </div><a href="javascript:;" class="item-edit"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-edit font-small-4">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between mx-0 row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">
                                Showing 1 to 7 of 100 entries</div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button page-item previous disabled"
                                        id="DataTables_Table_0_previous"><a href="#" aria-controls="DataTables_Table_0"
                                            data-dt-idx="0" tabindex="0" class="page-link">&nbsp;</a></li>
                                    <li class="paginate_button page-item active"><a href="#"
                                            aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0"
                                            class="page-link">1</a></li>
                                    <li class="paginate_button page-item "><a href="#"
                                            aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0"
                                            class="page-link">2</a></li>
                                    <li class="paginate_button page-item "><a href="#"
                                            aria-controls="DataTables_Table_0" data-dt-idx="3" tabindex="0"
                                            class="page-link">3</a></li>
                                    <li class="paginate_button page-item "><a href="#"
                                            aria-controls="DataTables_Table_0" data-dt-idx="4" tabindex="0"
                                            class="page-link">4</a></li>
                                    <li class="paginate_button page-item "><a href="#"
                                            aria-controls="DataTables_Table_0" data-dt-idx="5" tabindex="0"
                                            class="page-link">5</a></li>
                                    <li class="paginate_button page-item disabled" id="DataTables_Table_0_ellipsis"><a
                                            href="#" aria-controls="DataTables_Table_0" data-dt-idx="6" tabindex="0"
                                            class="page-link">…</a></li>
                                    <li class="paginate_button page-item "><a href="#"
                                            aria-controls="DataTables_Table_0" data-dt-idx="7" tabindex="0"
                                            class="page-link">15</a></li>
                                    <li class="paginate_button page-item next" id="DataTables_Table_0_next"><a href="#"
                                            aria-controls="DataTables_Table_0" data-dt-idx="8" tabindex="0"
                                            class="page-link">&nbsp;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>













    {{-- 



  <div class="row match-height">
    <!-- Greetings Card starts -->
    <div class="col-lg-6 col-md-12 col-sm-12">
      <div class="card card-congratulations">
        <div class="card-body text-center">
          <img
            src="{{asset('images/elements/decore-left.png')}}"
    class="congratulations-img-left"
    alt="card-img-left"
    />
    <img src="{{asset('images/elements/decore-right.png')}}" class="congratulations-img-right" alt="card-img-right" />
    <div class="avatar avatar-xl bg-primary shadow">
        <div class="avatar-content">
            <i data-feather="award" class="font-large-1"></i>
        </div>
    </div>
    <div class="text-center">
        <h1 class="mb-1 text-white">Congratulations John,</h1>
        <p class="card-text m-auto w-75">
            You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.
        </p>
    </div>
    </div>
    </div>
    </div>
    <!-- Greetings Card ends -->

    <!-- Subscribers Chart Card starts -->
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-start pb-0">
                <div class="avatar bg-light-primary p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="users" class="font-medium-5"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">92.6k</h2>
                <p class="card-text">Subscribers Gained</p>
            </div>
            <div id="gained-chart"></div>
        </div>
    </div>
    <!-- Subscribers Chart Card ends -->

    <!-- Orders Chart Card starts -->
    <div class="col-lg-3 col-sm-6 col-12">
        <div class="card">
            <div class="card-header flex-column align-items-start pb-0">
                <div class="avatar bg-light-warning p-50 m-0">
                    <div class="avatar-content">
                        <i data-feather="package" class="font-medium-5"></i>
                    </div>
                </div>
                <h2 class="font-weight-bolder mt-1">38.4K</h2>
                <p class="card-text">Orders Received</p>
            </div>
            <div id="order-chart"></div>
        </div>
    </div>
    <!-- Orders Chart Card ends -->
    </div>

    <div class="row match-height">
        <!-- Avg Sessions Chart Card starts -->
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row pb-50">
                        <div
                            class="col-sm-6 col-12 d-flex justify-content-between flex-column order-sm-1 order-2 mt-1 mt-sm-0">
                            <div class="mb-1 mb-sm-0">
                                <h2 class="font-weight-bolder mb-25">2.7K</h2>
                                <p class="card-text font-weight-bold mb-2">Avg Sessions</p>
                                <div class="font-medium-2">
                                    <span class="text-success mr-25">+5.2%</span>
                                    <span>vs last 7 days</span>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary">View Details</button>
                        </div>
                        <div
                            class="col-sm-6 col-12 d-flex justify-content-between flex-column text-right order-sm-2 order-1">
                            <div class="dropdown chart-dropdown">
                                <button class="btn btn-sm border-0 dropdown-toggle p-50" type="button"
                                    id="dropdownItem5" data-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Last 7 Days
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem5">
                                    <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                                </div>
                            </div>
                            <div id="avg-sessions-chart"></div>
                        </div>
                    </div>
                    <hr />
                    <div class="row avg-sessions pt-50">
                        <div class="col-6 mb-2">
                            <p class="mb-50">Goal: $100000</p>
                            <div class="progress progress-bar-primary" style="height: 6px">
                                <div class="progress-bar" role="progressbar" aria-valuenow="50" aria-valuemin="50"
                                    aria-valuemax="100" style="width: 50%"></div>
                            </div>
                        </div>
                        <div class="col-6 mb-2">
                            <p class="mb-50">Users: 100K</p>
                            <div class="progress progress-bar-warning" style="height: 6px">
                                <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="60"
                                    aria-valuemax="100" style="width: 60%"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="mb-50">Retention: 90%</p>
                            <div class="progress progress-bar-danger" style="height: 6px">
                                <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="70"
                                    aria-valuemax="100" style="width: 70%"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <p class="mb-50">Duration: 1yr</p>
                            <div class="progress progress-bar-success" style="height: 6px">
                                <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="90"
                                    aria-valuemax="100" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Avg Sessions Chart Card ends -->

        <!-- Support Tracker Chart Card starts -->
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between pb-0">
                    <h4 class="card-title">Support Tracker</h4>
                    <div class="dropdown chart-dropdown">
                        <button class="btn btn-sm border-0 dropdown-toggle p-50" type="button" id="dropdownItem4"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Last 7 Days
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownItem4">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-2 col-12 d-flex flex-column flex-wrap text-center">
                            <h1 class="font-large-2 font-weight-bolder mt-2 mb-0">163</h1>
                            <p class="card-text">Tickets</p>
                        </div>
                        <div class="col-sm-10 col-12 d-flex justify-content-center">
                            <div id="support-trackers-chart"></div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <div class="text-center">
                            <p class="card-text mb-50">New Tickets</p>
                            <span class="font-large-1 font-weight-bold">29</span>
                        </div>
                        <div class="text-center">
                            <p class="card-text mb-50">Open Tickets</p>
                            <span class="font-large-1 font-weight-bold">63</span>
                        </div>
                        <div class="text-center">
                            <p class="card-text mb-50">Response Time</p>
                            <span class="font-large-1 font-weight-bold">1d</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Support Tracker Chart Card ends -->
    </div>

    <div class="row match-height">
        <!-- Timeline Card -->
        <div class="col-lg-4 col-12">
            <div class="card card-user-timeline">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <i data-feather="list" class="user-timeline-title-icon"></i>
                        <h4 class="card-title">User Timeline</h4>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="timeline ml-50 mb-0">
                        <li class="timeline-item">
                            <span class="timeline-point timeline-point-indicator"></span>
                            <div class="timeline-event">
                                <h6>12 Invoices have been paid</h6>
                                <p>Invoices are paid to the company</p>
                                <div class="media align-items-center">
                                    <img class="mr-1" src="{{asset('images/icons/json.png')}}" alt="data.json"
                                        height="23" />
                                    <h6 class="media-body mb-0">data.json</h6>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <span class="timeline-point timeline-point-warning timeline-point-indicator"></span>
                            <div class="timeline-event">
                                <h6>Client Meeting</h6>
                                <p>Project meeting with Carl</p>
                                <div class="media align-items-center">
                                    <div class="avatar mr-50">
                                        <img src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" alt="Avatar"
                                            width="38" height="38" />
                                    </div>
                                    <div class="media-body">
                                        <h6 class="mb-0">Carl Roy (Client)</h6>
                                        <p class="mb-0">CEO of Infibeam</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <span class="timeline-point timeline-point-info timeline-point-indicator"></span>
                            <div class="timeline-event">
                                <h6>Create a new project</h6>
                                <p>Add files to new design folder</p>
                                <div class="avatar-group">
                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                                        data-original-title="Billy Hopkins" class="avatar pull-up">
                                        <img src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" alt="Avatar"
                                            width="33" height="33" />
                                    </div>
                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                                        data-original-title="Amy Carson" class="avatar pull-up">
                                        <img src="{{asset('images/portrait/small/avatar-s-6.jpg')}}" alt="Avatar"
                                            width="33" height="33" />
                                    </div>
                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                                        data-original-title="Brandon Miles" class="avatar pull-up">
                                        <img src="{{asset('images/portrait/small/avatar-s-8.jpg')}}" alt="Avatar"
                                            width="33" height="33" />
                                    </div>
                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                                        data-original-title="Daisy Weber" class="avatar pull-up">
                                        <img src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" alt="Avatar"
                                            width="33" height="33" />
                                    </div>
                                    <div data-toggle="tooltip" data-popup="tooltip-custom" data-placement="bottom"
                                        data-original-title="Jenny Looper" class="avatar pull-up">
                                        <img src="{{asset('images/portrait/small/avatar-s-20.jpg')}}" alt="Avatar"
                                            width="33" height="33" />
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-item">
                            <span class="timeline-point timeline-point-danger timeline-point-indicator"></span>
                            <div class="timeline-event">
                                <h6>Update project for client</h6>
                                <p class="mb-0">Update files as per new design</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Timeline Card -->

        <!-- Sales Stats Chart Card starts -->
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-start pb-1">
                    <div>
                        <h4 class="card-title mb-25">Sales</h4>
                        <p class="card-text">Last 6 months</p>
                    </div>
                    <div class="dropdown chart-dropdown">
                        <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-toggle="dropdown"></i>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-inline-block mr-1">
                        <div class="d-flex align-items-center">
                            <i data-feather="circle" class="font-small-3 text-primary mr-50"></i>
                            <h6 class="mb-0">Sales</h6>
                        </div>
                    </div>
                    <div class="d-inline-block">
                        <div class="d-flex align-items-center">
                            <i data-feather="circle" class="font-small-3 text-info mr-50"></i>
                            <h6 class="mb-0">Visits</h6>
                        </div>
                    </div>
                    <div id="sales-visit-chart" class="mt-50"></div>
                </div>
            </div>
        </div>
        <!-- Sales Stats Chart Card ends -->

        <!-- App Design Card -->
        <div class="col-lg-4 col-md-6 col-12">
            <div class="card card-app-design">
                <div class="card-body">
                    <div class="badge badge-light-primary">03 Sep, 20</div>
                    <h4 class="card-title mt-1 mb-75 pt-25">App design</h4>
                    <p class="card-text font-small-2 mb-2">
                        You can Find Only Post and Quotes Related to IOS like ipad app design, iphone app design
                    </p>
                    <div class="design-group mb-2 pt-50">
                        <h6 class="section-label">Team</h6>
                        <div class="badge badge-light-warning mr-1">Figma</div>
                        <div class="badge badge-light-primary">Wireframe</div>
                    </div>
                    <div class="design-group pt-25">
                        <h6 class="section-label">Members</h6>
                        <div class="avatar">
                            <img src="{{asset('images/portrait/small/avatar-s-9.jpg')}}" width="34" height="34"
                                alt="Avatar" />
                        </div>
                        <div class="avatar bg-light-danger">
                            <div class="avatar-content">PI</div>
                        </div>
                        <div class="avatar">
                            <img src="{{asset('images/portrait/small/avatar-s-14.jpg')}}" width="34" height="34"
                                alt="Avatar" />
                        </div>
                        <div class="avatar">
                            <img src="{{asset('images/portrait/small/avatar-s-7.jpg')}}" width="34" height="34"
                                alt="Avatar" />
                        </div>
                        <div class="avatar bg-light-secondary">
                            <div class="avatar-content">AL</div>
                        </div>
                    </div>
                    <div class="design-planning-wrapper mb-2 py-75">
                        <div class="design-planning">
                            <p class="card-text mb-25">Due Date</p>
                            <h6 class="mb-0">12 Apr, 21</h6>
                        </div>
                        <div class="design-planning">
                            <p class="card-text mb-25">Budget</p>
                            <h6 class="mb-0">$49251.91</h6>
                        </div>
                        <div class="design-planning">
                            <p class="card-text mb-25">Cost</p>
                            <h6 class="mb-0">$840.99</h6>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-block">Join Team</button>
                </div>
            </div>
        </div>
        <!--/ App Design Card -->
    </div>

    <!-- List DataTable -->
    <div class="row">
        <div class="col-12">
            <div class="card invoice-list-wrapper">
                <div class="card-datatable table-responsive">
                    <table class="invoice-list-table table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th><i data-feather="trending-up"></i></th>
                                <th>Client</th>
                                <th>Total</th>
                                <th class="text-truncate">Issued Date</th>
                                <th>Balance</th>
                                <th>Invoice Status</th>
                                <th class="cell-fit">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}
    <!--/ List DataTable -->
</section>
<!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
<!-- vendor files -->
{{-- <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/moment.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/responsive.bootstrap.min.js') }}"></script> --}}
@endsection
@section('page-script')
<!-- Page js files -->
{{-- <script src="{{ asset('js/scripts/pages/dashboard-analytics.js') }}"></script>
<script src="{{ asset('js/scripts/pages/app-invoice-list.js') }}"></script> --}}
@endsection
