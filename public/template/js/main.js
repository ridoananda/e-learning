$(function () {
  $("#dataTable").DataTable();
  $('#summernote').summernote({
    placeholder: 'Text',
    tabsize: 2,
    height: 300,
    codeviewIframeFilter: true,
    toolbar: [
      ['style', ['style']],
      ['font', ['bold', 'underline', 'clear', 'strikethrough', 'superscript', 'subscript']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture']],
      ['height'],
      ['view', ['fullscreen', 'codeview', 'undo', 'redo', 'help']],
    ],
    callbacks: {
      onImageUpload: function (image) {
        uploadImage(image[0]);
      },
      // onInit: function() {
      //   $(".note-editable").css('line-height','0.8');
      // },
    //   onPaste: function (e) {
    //     var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
    //     e.preventDefault();
    //     document.execCommand('insertText', false, bufferText);
    // },
      onMediaDelete: function (target) {
        deleteImage(target[0].src);
      }
    }
  });

  function uploadImage(image) {
    var data = new FormData();
    data.append("image", image);
    $.ajax({
      url: "/aplikasi/guru/upload_image_artikel",
      cache: false,
      contentType: false,
      processData: false,
      data: data,
      type: "POST",
      dataType: 'json',
      success: function (url) {
        $('#summernote').summernote("insertImage", url);
        console.log(url);
        if (url.error) {
          swal('Error!', url.error, 'error');
        }
      },
      error: function (data) {
        console.log(data);
      }
    });
  }

  function deleteImage(src) {
    $.ajax({
      data: {
        src: src
      },
      type: "POST",
      url: "/aplikasi/guru/delete_image_artikel",
      cache: false,
      success: function (response) {
        console.log(response);
      }
    });
  }
  $("#file").change(function (e) {
    e.preventDefault();
    const file = document.querySelector("#file").files;
    $("#namaFile span").remove();
    $.map(file, function (e) {
      $("#namaFile").append(
        '<span class="d-block text-break"><i class="fas fa-file-alt fa-sm fa-fw"></i> ' +
        e.name +
        "</span>"
      );
      $("#namaFIle span").fadeIn();
    });
  });
  $("input#image").change(function (e) {
    e.preventDefault();
    const image = document.querySelector("#image");
    const imageLabel = document.querySelector(".custom-file-label");
    const imgPreview = document.querySelector("#imgPreview");

    imageLabel.textContent = image.files[0].name;

    const imageFile = new FileReader();
    imageFile.readAsDataURL(image.files[0]);

    imageFile.onload = function (e) {
      imgPreview.src = e.target.result;
    };
  });

  // HAPUS SUBMENU
  $("#hapusSubMenuModal").on("show.bs.modal", function (e) {
    const div = $(e.relatedTarget);
    $("form#hapusSubMenu button[type=submit]").click(function (e) {
      const id = div.data("id");
      e.preventDefault();
      $.ajax({
        type: "post",
        url: "/aplikasi/menu/hapus_sub_menu",
        data: {
          id: id,
        },
        dataType: "html",
        success: function (response) {
          window.location.href = "/aplikasi/menu/submenu";
        },
      });
    });
  });

  // UBAH MENU
  const btnUbahMenu = document.querySelectorAll("#btnUbahMenu");
  $(btnUbahMenu).click(function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const menu = $(this).data("menu");
    $("form#ubahMenu input[type=text]").val(menu);
    $("#ubahMenuModal").modal("show");
    $("form#ubahMenu button[type=submit]").click(function (e) {
      const menuVal = $("form#ubahMenu input[type=text]").val();
      console.log(menuVal);
      e.preventDefault();
      $.ajax({
        type: "post",
        url: "/aplikasi/menu/ubah_menu/" + id,
        data: {
          menu: menuVal,
        },
        dataType: "html",
        success: function (response) {
          window.location.href = "/aplikasi/menu";
        },
      });
    });
  });

  // ROLE ACCESS
  $(".roleAccess").click(function (e) {
    e.preventDefault();
    const role_id = $(this).data("role_id");
    const menu_id = $(this).data("menu_id");
    $.ajax({
      type: "post",
      url: "/aplikasi/admin/ubah_role",
      data: {
        role_id: role_id,
        menu_id: menu_id,
      },
      dataType: "html",
      success: function (response) {
        document.location.href = "/aplikasi/admin/role_access/" + role_id;
      },
    });
  });


  // UBAH ROLE
  const btnUbahRole = document.querySelectorAll("#btnUbahRole");
  $(btnUbahRole).click(function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const name = $(this).data("name");
    $("form#ubahRole input[type=text]").val(name);
    $("#ubahRoleModal").modal("show");
    $("form#ubahRole button[type=submit]").click(function (e) {
      const nameVal = $("form#ubahRole input[type=text]").val();
      e.preventDefault();
      $.ajax({
        type: "post",
        url: "/aplikasi/admin/ubah_nama_role",
        data: {
          id: id,
          name: nameVal,
        },
        dataType: "html",
        success: function (response) {
          window.location.href = "/aplikasi/admin/role";
        },
      });
    });
  });

  // UBAH MAPEL GURU
  const btnUbahMapel = document.querySelectorAll("#btnUbahMapel");
  $(btnUbahMapel).click(function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const mapel = $(this).data("mapel");
    const kelas = $(this).data("kelas");
    const jurusan = $(this).data("jurusan");
    $("form#ubahMapel input[name=mapel]").val(mapel);

    $("form#ubahMapel button[type=submit]").click(function (e) {
      const mapel = $("form#ubahMapel input[name=mapel]").val();
      e.preventDefault();
      $.ajax({
        type: "post",
        url: "/aplikasi/admin/ubah_mapel",
        data: {
          id: id,
          mapel: mapel,
        },
        dataType: "html",
        success: function (response) {
          window.location.href = "/aplikasi/admin/mapel";
        },
      });
    });
  });
  // UBAH KElAS DAN JURUSAN
  $(btnUbahMapel).click(function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const kelas = $(this).data("kelas");
    const jurusan = $(this).data("jurusan");
    $("form#ubahKelas input[name=kelas]").val(kelas);
    $("form#ubahKelas input[name=jurusan]").val(jurusan);

    $("form#ubahKelas button[type=submit]").click(function (e) {
      const kelas = $("form#ubahKelas input[name=kelas]").val();
      const jurusan = $("form#ubahKelas input[name=jurusan]").val();
      e.preventDefault();
      $.ajax({
        type: "post",
        url: "/aplikasi/admin/ubah_kelas",
        data: {
          id: id,
          kelas: kelas,
          jurusan: jurusan,
        },
        dataType: "html",
        success: function (response) {
          window.location.href = "/aplikasi/admin/mapel";
        },
      });
    });
  });

  // UBAH ABSEN
  $("#ubahAbsenModal").on("show.bs.modal", function (e) {
    const div = $(e.relatedTarget);
    $(this)
      .find("form#ubahAbsen select#mapel_id option")
      .attr("value", div.data("id"));
    const kelas = div.data("kelas");
    const jurusan = div.data("jurusan");
    console.log(kelas);
    $("form#ubahAbsen select#mapel_id option").html(kelas + " - " + jurusan);
    $("form#ubahAbsen button[type=submit]").click(function (e) {
      const expired = $("form#ubahAbsen input[name=expired]").val();
      e.preventDefault();
      const id = div.data("id");
      $.ajax({
        type: "post",
        url: "/aplikasi/guru/ubah_absen",
        data: {
          id: id,
          expired: expired,
        },
        dataType: "html",
        success: function (response) {
          window.location.href = "/aplikasi/guru/absen";
        },
      });
    });
  });

  $('#gambarModal').on('show.bs.modal', function (e) {
    const div = $(e.relatedTarget);
    $('#img').attr('src', '/file/tugas/' + div.data('src'));
    $('#lihatPenuh').attr('href', '/file/tugas/' + div.data('src'));
  });

  // CEK NOTIF
  $('a#lihatNotif').click(function (e) {
    e.preventDefault();
    const url = $(this).data('url');
    const id = $(this).data('id');
    const menu = $(this).data('menu');
    $.ajax({
      type: "post",
      url: "/aplikasi/" + menu + "/cek_notif",
      data: {
        id: id
      },
      success: function (response) {
        window.location.href = url
      }
    });
  });

  
  // ABSEN SISWA
  $("#barisAlasan").hide();
  $("#hadir").click(function () {
    $("#barisAlasan").hide();
  });
  $("#sakit, #izin").click(function () {
    $("#barisAlasan").show();
  });
});