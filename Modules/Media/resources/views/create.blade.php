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
                <form class="form-horizontal form-label-left" action="{{ route('media.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cloud" id="cloud">
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Name</label>
                        <div class="col-md-9 col-sm-9 ">
                            <input type="text" name="name" class="form-control" placeholder="Name" required>
                            <small>When the name contains 'bg_website,' 'bg_tablet,' or 'bg_mobile,' limit the image selection to one, as these images will be used for the system background. If you wish to change the background images, you are required to upload three distinct images with the specified names.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3">Cloud</label>
                        <div class="col-md-9 col-sm-9">
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-success">
                                    <input type="radio" name="cloud" value="1"> Yes
                                </label>
                                <label class="btn btn-danger active">
                                    <input type="radio" name="cloud" value="0" checked> No
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 ">Upload medias</label>
                        <div class="col-md-9 col-sm-9">
                            <div role="main">
                                <div class="">
                                    <div class="clearfix"></div>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 ">
                                            <p>Drag multiple files to the box below for multi-upload or click to select files.</p>
                                            <div class="images @error('images')is-invalid @enderror" style="cursor: pointer;">
                                                <input type="hidden" name="images[]" id="images" multiple />
                                            </div>
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
    $(document).ready(function() {
        function initializeUploader(maxFiles) {
            $('.images').empty();
            return $('.images').imageUploader({
                extensions: ['.jpg', '.jpeg', '.png', '.gif', '.svg', '.PNG'],
                maxFiles: maxFiles
            });
        }

        var uploader = initializeUploader(1);

        $('input[name="name"]').on('input', function() {
            var nameValue = $(this).val().toLowerCase();
            var newMaxFiles = nameValue.includes('bg_website') || nameValue.includes('bg_tablet') || nameValue.includes('bg_mobile') ? 1 : 50;
            uploader = initializeUploader(newMaxFiles);
        });
    });
</script>
@endpush


