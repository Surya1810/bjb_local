@extends('layouts.admin')

@section('title')
    Home
@endsection

@push('css')
@endpush

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Home</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $users }}</h3>

                                <strong>User</strong>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $documents }}</h3>

                                <strong>Document</strong>
                            </div>
                            <div class="icon">
                                <i class="fas fa-regular fa-folder-open"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $agunans }}</h3>

                                <strong>Agunan</strong>
                            </div>
                            <div class="icon">
                                <i class="fas fa-regular fa-file"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-lg-3 col-6">
                    <a href="#">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $tags }}</h3>

                                <strong>Tag RFID Remaining</strong>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-tags"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
