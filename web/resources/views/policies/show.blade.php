@include('Layouts.header')
@include('Layouts.mobilemenu')

<div class="breadcumb-area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 txtc text-center ccase">
                <div class="brpt brptsize">
                    <h1 class="brcrumb_title">{{ ucwords($policyName) }}</h1>
                </div>
                <div class="breadcumb-inner">
                    <ul>
                        <li>You Here!- </li>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li> -<span class="current">{{ ucwords($policyName) }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="jl_test_area" style="padding: 20px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="tts text-center">
                    {!! $content !!}
                </span>
            </div>
        </div>
    </div>
</div>

@include('Layouts.footer')
