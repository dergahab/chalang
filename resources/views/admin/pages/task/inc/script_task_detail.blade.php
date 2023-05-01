

@push('js_stack')
<script>
    $(document).ready(function() {

        function modalloder(){
            $(document).find('#preloader').show();

            console.log('Test');
        }
       
        $(document).on('click', '.show-deatil', function() {
    
                let id = $(this).data('id');
                let url = "{{ route('task.details', 'show') }}"
                url = url.replace('show', id);
                pageLoader(true);
                $.get(url,
                    function(response) {
                        if (response.code == 200) {
                            $("#details").html(response.data)

                            $("#detaleModal").modal('toggle');
                        }
                        pageLoader(false);
                    });
            })
            
            $(document).on('click', "#comment", function() {
                let conetent = $('#coment-text').val();

                let data = {
                    id: $('#task-id').val(),
                    content: $('#coment-text').val()
                }
                console.log(data)

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (conetent.length > 1) {
                    $.ajax({
                        enctype: 'multipart/form-data',
                        type: "POST",
                        url: "{{ route('task.comment') }}",
                        data: data,
                        cache: false,

                        success: function(response) {
                            $("#comments-box").append(response.view);
                            $('#scrollable').animate({
                                scrollTop: $('#scrollable')[0].scrollHeight
                            }, 2000);
                            $("#coment-text").val('');
                        },
                        error: function(error) {
                            $.each(error.responseJSON, function(index, value) {
                                toastr.error(value)
                                return false;
                            });
                        }
                    });
                }
            })

  

    $(document).on('click','.assine-user',function (e) { 
      e.preventDefault();
      pageLoader(true);
      let data = {
          _token: "{{ csrf_token() }}",
          user: $(this).data('user'),
          task: $(this).data('task'),
      }
     
      $.post("{{route('asssine-user')}}", data,
          function (response) {
              $("#task-users").html(response.view);
              pageLoader(false);
              dTReload();
              toastr.success('Personal tehkim edildi');
             
              $(document).find('.task-users').tab('show');
          });
    });


      $(document).on('click','.add-files',function (e) { 
          e.preventDefault();
          $('#file-input').click()
       });

      $(document).on('change','#file-input',function (e) { 
          e.preventDefault();
          
          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          formData = new FormData();

          var totalfiles = document.getElementById('file-input').files.length;

          for (var index = 0; index < totalfiles; index++) {
              formData.append("file[]", document.getElementById('file-input').files[index]);
          }
          formData.append("_token", "{{ csrf_token() }}");
          formData.append("task", $(this).data('task'));

          pageLoader(true);
          $.ajax({
              enctype: 'multipart/form-data',
              type: "POST",
              url: "{{ route('filess_upload') }}",
              data: formData,
              processData: false,
              contentType: false,
              success: function(response) {
                 
                  $("#task-files").html(response.view);
                  pageLoader(false);
                //   toastr.success('Fayl elave edildi');
                  Swal.fire({
                    title: 'Fayl elave edildi.',
                    icon: 'success',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'OK'
                })
                  $(document).find('.product1').tab('show');
              },
              error: function(error) {
                  $.each(error.responseJSON, function(index, value) {
                      toastr.error(value);
                  });
                  pageLoader(false);
              }
          });
       });


   $(document).on('change','#statuses',function(e){
   
    let data = {
          _token: "{{ csrf_token() }}",
          status_id : $(this).val(),
          task: $("#task_id").val(),
      }
    
      $.post("{{route('task.status')}}", data,
          function (response) {
            //   $("#task-users").html(response.view);
              pageLoader(false);
              dTReload();
              toastr.success('Tapşırıq status dəyişdi');
          });
   })


    $(document).on('change','.to-do',function(){
        let data = {
          _token: "{{ csrf_token() }}",
          checbox : $(this).val(),
          task: $("#task_id").val(),
      }

      console.log(data);

      $.post("{{route('task.checklist.status')}}", data,
        function (response) {
            toastr.success('Əməliyyat tamamlandı');
        });
    })


    $(document).on('click','#chechlist-add',function(){
        modalloder()
       let data = $("#todo-form").serialize();
       let val = $("input[name=content]").val();
        if(val.length === 0){
            toastr.error('List element daxil edin');
            return flase;
        }
        $.post("{{route('task.checklist.add')}}", data,
            function (response) {
                $("#checklist-list").html(response.view)
                $("#todo-form").trigger("reset");
                toastr.success('Əməliyyat tamalandı');
                // modalloder();
            });
        })

    });

    $(document).on('change','#complated',function(){

        $('.to-do').each(function () {
            if ($(this).is(":checked")) {
                $(this).parent().toggle();
            } 
        });
    });
    $(document).on('dblclick','.to-do-text',function(){

       let text =  $.trim($(this).text());
       let id = $(this).data('id');
       $(this).replaceWith(` 
       <div class="w-100">
            <input rows="3" value="${text}"  class="w-100 textarea-checklist edit-checklist">
            <input type="hidden" class="edit-checklist-id"  value="${id}">
            <div class="buttons d-flex gap-3 align-items-center">
                <button class=" btn-sm button-checklist chcklist-update">Save</button>
                // <i class="fa-solid fa-xmark fs-25"></i>
            </div>
        </div>
       `)
    });

    $(document).on('click','.chcklist-update',function(){
        let data = {
            content: $('.edit-checklist').val(),
            id :  $('.edit-checklist-id').val(),
            task_id: $('#task_id').val(),
            _token: "{{ csrf_token()}}"
    }
        $.post(" {{route('task.checklist.edit')}}", data,
            function (response) {
                $("#checklist-list").html(response.view)
            });
    });

    $(document).on('click','.display-checklist-delete',function(){
        let data = {
            id :  $(this).attr('data-id'),
            task_id: $('#task_id').val(),
            _token: "{{ csrf_token()}}"
    }
        $.post(" {{route('task.checklist.delete')}}", data,
            function (response) {
                $("#checklist-list").html(response.view)
            });
    });
</script>
@endpush