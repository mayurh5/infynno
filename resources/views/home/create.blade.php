@extends('layouts.app-master')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
@section('content')
<section class="users-edit">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs mb-2" role="tablist">
                <li class="nav-item">
                    <h4>Create Blog</h4>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active fade show" id="account" aria-labelledby="account-tab" role="tabpanel">
                    <!-- users edit media object start -->
                    <!-- users edit media object ends -->
                    <!-- users edit account form start -->
                    <form action="#" id="blogFrm" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-4">
                            </div>
                            <div class="col-12 col-md-8 left-section">
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                        <label>Blog Title</label>
                                        <input type="text" class="form-control title" placeholder="Blog Title" required 
                                            name="title" >
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                        <label>description</label>
                                        <textarea type="text" class="form-control" name="description" rows="3"
                                            cols="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                        <label>Image</label>
                                        <input type="file" class="form-control" placeholder="Image" 
                                             name="image" id="file">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                        <label>Expiration Date</label>
                                        <input type="datetime-local" class="form-control" placeholder="Expiration Date" 
                                            name="expiration">
                                    </div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="controls">
                                    <label>Publish</label>
                                    <select class="form-control"  name="published">
                                       <option value="1">Private</option>
                                       <option value="0">Public</option>
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

<script>

$(document).on('click', '#SubmitBlog', function (e) {
            e.preventDefault();

           var formData = new FormData(document.getElementById("blogFrm"));
       
            var files = $('#file')[0].files;
            formData.append('file',files[0]);

            $.ajax({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               url: "{{route('blog.store')}}",
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