<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
    <meta name="Author" content="Spruko Technologies Private Limited">
    <meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>
    @include('layouts.head')
</head>

<body class="main-body app sidebar-mini">
<!-- Loader -->
<div id="global-loader">
    <img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
</div>
<!-- /Loader -->
<!-- main-content -->
<div class="main-content app-content">
    @include('layouts.main-header')
    <!-- container -->
    <div class="container">
        <div class="breadcrumb-header justify-content-between">
            <div class="my-auto">
                <div class="d-flex">
                    <h4 class="content-title mb-0 my-auto">الشركات</h4>
                </div>
            </div>

        </div>


        <div class="row row-sm">
            @foreach($company as $item)
            <div class="col-md-4 col-lg-4">
                <div class="card">
                    <a href="{{ route('dashboard.view', $item->id) }}">
                        <img alt="Image" class="img-fluid card-img-top" src="{{ asset($item->company_image) }}"
                         style="width:360px; height:250px">
                    </a>
                    <div class="card-body ">
                        <a href="{{ route('dashboard.view', $item->id) }}" >
                            <strong class="card-text">{{ $item->company_name }}</strong>
                        </a>
                    </div>
                </div>
            </div><!-- col-4 -->
            @endforeach
        </div>


    </div>
</div>

@include('layouts.models')
@include('layouts.footer-scripts')
</body>
</html>
