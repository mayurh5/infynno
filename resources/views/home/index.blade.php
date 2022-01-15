@extends('layouts.app-master')
@section('content')
    <div class="bg-light p-5 rounded">
        @auth
        <h1>Blogs</h1>
        <a class=" btn btn-primary mr-1 mb-1" href="{{ route('blog.create') }}"><i class="bx bx-plus"></i> Create Blog</a>
  
        <table id="blog" class="display dataTable responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No.</th>
                <th>Image</th>
                <th>Title</th>
                <th>Exp.Date.</th>
                <th>Publish</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>

        </tfoot>
    </table>    

        @endauth

        @guest\

        <h1>Homepage</h1>
        <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>
        @endguest
    </div>
@endsection


@section('script')

<script>
    $(document).ready(function(){
        $('#blog').DataTable({
            'processing': true,
            'serverSide': true,
            'serverMethod': 'get',

            'ajax': {
                'url':'{{route("blog.list")}}',
                dataSrc : function (result) {
                return result;
                }
            },

            'columns': [
                    {
                        "data": "",
                        "render": function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                {
                "data": "image",
                "render": function(data, type, row) {
                                return '<img src="images/'+row.image+'"  width="30" height="40">';
                            }
                },
                { data: 'title' },
                { data: 'expiration' },
                { data: 'published' ,
                    "render": function ( data, type, row ) {
                                    var html = '';
                                    if(row.published == '0'){
                                        html = 'Public';
                                    }else if(row.published == '1'){
                                        html = 'Private';
                                    }
                                    return html;
                                }
                            },
                { data: '',
                    "render": function(data, type, row) {
                                var html = '';
                                html += ' <a href="edit/blog/' + row.id + '"><i class="float-top " data-id="' + row.id + '"><i class="bx bx-trash text-danger bx-sm"></i>Edit</a>';
                                html += ' <a href=""><i class="float-top remove_blog" data-id="' + row.id + '"><i class="bx bx-trash text-danger bx-sm"></i>Delete</a>';

                                return html;
                            } },
            ]
        });
    });

    $('body').on('click', '.remove_blog', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');

        $.ajax({
               url: 'delete/blog/'+ id,
               method: 'get',
               cache:false,
               processData: false,
               contentType: false,
               success: function(data) {
                   if (data.alert_type == "success") {
                      window.location.reload();
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
