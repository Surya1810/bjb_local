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
                <div class="col-lg-2 col-6">
                    <a href="{{ route('document.index') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">Document List</h4>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-6">
                    <a href="{{ route('document.index') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">Agunan List</h4>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-6">
                    <a href="{{ route('scan.index_document') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">Scan Document</h4>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-6">
                    <a href="{{ route('scan.index_agunan') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">Scan Agunan</h4>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-6">
                    <a href="{{ route('report.index') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">Report</h4>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-6">
                    <a href="{{ route('history.index') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">Changes History</h4>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-user"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-6">
                    <a href="{{ route('document.index') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">Document Detail</h4>
                            </div>
                            <div class="icon">
                                <i class="fas fa-regular fa-folder-open"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-6">
                    <a href="{{ route('user.index') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">User List</h4>
                            </div>
                            <div class="icon">
                                <i class="fas fa-regular fa-file"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>

                <div class="col-lg-2 col-6">
                    <a href="{{ route('tag.index') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">Tag RFID</h4>
                            </div>
                            <div class="icon">
                                <i class="fas fa-solid fa-tags"></i>
                            </div>
                            <span class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></span>
                        </div>
                    </a>
                </div>
                <div class="col-lg-2 col-6">
                    <a href="{{ route('tag.index') }}">
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4 class="mb-4">Location</h4>
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
