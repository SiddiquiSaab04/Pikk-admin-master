@extends('layouts.master')
@section('content')
@include('layouts.descriptions')
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="x_panel">
            <div class="x_title">
                <a href="{{ route('media.index') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8" />
                    </svg>
                </a>
                <ul class="nav navbar-right panel_toolbox justify-content-end">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <br />
                <form class="form-horizontal form-label-left" method="post" action="{{ route('media.update', $media->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Name</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="name" class="form-control" value="{{$media->name}}" required>
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">Cloud</label>
                        <div class="col-md-9 col-sm-9">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-success {{ $media->cloud == 1 ? 'active' : '' }}">
                                    <input type="radio" name="cloud" value="1" {{ $media->cloud == 1 ? 'checked' : '' }}> Yes
                                </label>
                                <label class="btn btn-danger {{ $media->cloud == 0 ? 'active' : '' }}">
                                    <input type="radio" name="cloud" value="0" {{ $media->cloud == 0 ? 'checked' : '' }}> No
                                </label>
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">Upload medias</label>
                        <div class="col-md-9 col-sm-9">
                            <div role="main">
                                <div class="">
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <p>Drag multiple files to the box below for multi-upload or click to select files.</p>
                                            <div class="images @error('images') is-invalid @enderror" style="cursor: pointer;">
                                                <input type="hidden" name="images[]" id="images"/>
                                            </div>
                                            @error('images')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-9 col-sm-9 offset-md-3">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.images').imageUploader({
        extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg', 'PNG'],
        maxFiles: 1, 
        preloaded: [{
            id: '{{ $media->url }}',
            src: '{{ $media->url }}'
        }],
        preloadedInputName: 'oldImages'
    });
</script>
@endpush