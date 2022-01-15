@extends('layouts.app-master')
@section('content')
<section class="users-edit">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-2" role="tablist">
                <li class="nav-item">
                    <h4>Edit Blog</h4>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
                    <!-- users edit media object start -->
                    <!-- users edit media object ends -->
                    <!-- users edit account form start -->
                    <form action="#" id="blogFrm" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" name="id" value="{{$edit_blog->id}}" id="">
                        <div class="row">
                            <div class="col-12 col-md-4">
                            </div>
                            <div class="col-12 col-md-8 left-section">
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                        <label>Blog Title</label>
                                        <input type="text" class="form-control title" value="{{$edit_blog->title}}" placeholder="Blog Title" required 
                                            name="title" >
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                        <label>description</label>
                                        <textarea type="text" class="form-control" name="description" rows="3"
                                            cols="10">{!! $edit_blog->description !!}</textarea>
                                    </div>
                                </div>
                                @if(isset($edit_blog->image))
                                <div class="col-md-6 form-group">
                                <div id="blog_1_preview" class="image-fixed"><img src="{{asset('images/'.$edit_blog->image)}}" alt="" style ="object-fit: cover;" height="110" width="110"></div>
                                </div>
                                @else
                                <div id="blog_1_preview" class="card-img-top img"></div> 
                                @endif
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                        <label>Image</label>
                                        <input type="file" class="form-control" placeholder="Image" 
                                             name="image" id="blog_1" accept="image/x-png, image/jpeg">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                        <label>Expiration Date</label>
                                        <input type="datetime-local" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($edit_blog->expiration)) }}" placeholder="Expiration Date" 
                                            name="expiration">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                    <label>Publish</label>
                                    <select class="form-control"  name="published">
                                    <option value="0" {{ $edit_blog->published ==  "45"  ? 'selected' : '' }}> Public </option>
                                    <option value="1" {{ $edit_blog->published ==  "46"  ? 'selected' : '' }}> Private</option>
                                    </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end mt-1">
                            <button type="submit" id="SubmitBlog"
                                class="btn btn-primary glow mb-1 mb-sm-0 mr-0 mr-sm-1">Save
                            </button>
                            <a href="{{url()->previous()}}" class="btn btn-light">Cancel</a>
                        </div>
                    </form>
                    <!-- users edit account form ends -->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('script')

<script>
        $('#blog_1').on('change', function(e) {

            if (this.files && this.files[0]) {
                var selector = $(this).attr('id');
                var allowedExtensions = /(\jpg|\jpeg|\png|\gif|\JPG|\svg)$/i;
                var ext = this.files[0].type.split('/').pop();

                $('#' + selector + '_preview').html('');
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + selector + '_preview').append('<img class="img-fluid img" style="object-fit:cover"  src="' + e.target
                        .result + '">');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });


        $(document).on('click', '#SubmitBlog', function (e) {
            e.preventDefault();

           var formData = new FormData(document.getElementById("blogFrm"));
       
            var files = $('#blog_1')[0].files;
            formData.append('file',files[0]);

            $.ajax({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               url: "{{route('blog.update')}}",
               method: 'POST',
               data: formData,
               cache:false,
               processData: false,
               contentType: false,
               enctype: 'multipart/form-data',
               success: function(data) {
                   if (data.alert_type == "success") {
                    window.location = "{{route('home.index')}}"
                       toastr.success(data.message);
                   } else {
                      toastr.error(data.message);
                   }
               },
               error: function(error) {
                   console.log(error)
               }
           });

        });
</script>

@endsection