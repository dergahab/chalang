  $(document).ready(function() {
    $(".select2").select2();
});

$(document).on("click",".destroy",function(){
    let url = $(this).attr('route');
    let id = $(this).data('id');

    url = url.replace('destroy',id);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Ehtiyat təsdiqləmə sorğusu.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'İmtina et',
        confirmButtonText: 'Sil'
      }).then((result) => {
        if (result.isConfirmed) {
            console.log(result);
            if(result.isConfirmed){
                $.ajax({
                    type: "DELETE",
                    url: url,
                    data: { id: id},
                    success: function (response) {
                        if(response.code == 200){
                            toastr.success("Məlumat silindi")
                            $(document).find(detaleModal).modal('toggle');
                            dTReload();
                        }
                    }
                });
            }

         
        }
      })

});

$(document).on('click','.atendent_delete', function(){
    let id = $(this).data('id');
    let task = $(this).data('task');
    let url = $(this).attr('route');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'İşci bu taskın təhim olunalarıdan çıxarılsın?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'İmtina et',
        confirmButtonText: 'Təsdiqlə'
      }).then((result) => {
        if (result.isConfirmed) {
            if(result.isConfirmed){
                $.ajax({
                    type: "Post",
                    url: url,
                    data: { id: id,task:task},
                    success: function (response) {
                        if(response.code == 200){
                            toastr.success("Fayl silindi")
                            $('#task-peron-'+id).remove()
                            $('.data-tabe').DataTable().ajax.reload();
                        }
                    }
                });
            }

         
        }
      })
});


$(document).on('click','#file-delete', function(){
    let id = $(this).data('id');
    let task = $(this).data('task');
    let url = $(this).attr('route');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: 'Faylı silmək isətiyinizdən əminsiz?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'İmtina et',
        confirmButtonText: 'Sil'
      }).then((result) => {
        if (result.isConfirmed) {
            if(result.isConfirmed){
                $.ajax({
                    type: "Post",
                    url: url,
                    data: { id: id,task:task},
                    success: function (response) {
                        if(response.code == 200){
                            toastr.success("Fayl silindi")
                            $('#file-box-'+id).remove()
                            $('.data-tabe').DataTable().ajax.reload();
                        }
                    }
                });
            }

         
        }
      })
});

$(document).on('change','.status',function(e){
    let url = $(this).data('toggle-url');
    $.getJSON(url,
        function (data, textStatus, jqXHR) {
            toastr.success("Status dəyişdi")
        }
    );
})

// assine user filter
function myFunction() {
    var input, filter, ul, li, a, i, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName('span')[0];
        console.log(a)
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

// let
// localStorage.setItem('theme', 'dark'); 
// let sotore = localStorage.getItem('theme')

// mode.setAttribute('data-layout-mode',sotore)
$(document).on('click','.light-dark-mode',function(){
    mode = document.getElementsByTagName("HTML")[0].hasAttribute("data-layout-mode")
    mode.getAttribute("layout-mode-light");

    if (mode === 'dark') {
        alert('dark')
        document.documentElement.setAttribute('layout-mode-light', 'dark');
        localStorage.setItem('data-layout-mode', 'dark');
    } else if(mode === 'light'){
        alert('light')
        document.documentElement.setAttribute('data-layout-mode', 'light');
        localStorage.setItem('data-layout-mode', 'light'); 
    }else{
        alert('olmadi heyif')
    }
})

// const toggleSwitch = document.querySelector('.header-item .light-dark-mode');

//     function switchTheme(e) {
//         if (e.target.checked) {
//             document.documentElement.setAttribute('data-layout-mode', 'dark');
//             localStorage.setItem('theme', 'dark');
//         } else {

//             document.documentElement.setAttribute('data-layout-mode', 'light');
//             localStorage.setItem('theme', 'light'); 
//         }
//     }

//     const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;

//     if (currentTheme) {
//         document.documentElement.setAttribute('data-layout-mode', currentTheme);

//         if (currentTheme === 'dark') {
//             toggleSwitch.checked = true;
//         }
//     }

//     toggleSwitch.addEventListener('change', switchTheme, false);
