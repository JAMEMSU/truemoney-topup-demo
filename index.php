<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Kanit&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Kanit', sans-serif;
    }

    .btn-topup {
      background-color: #ff5928;
      color: #fff;
    }
  </style>

  <title>TrueMoney</title>
</head>

<body>
  <!-- As a heading -->
  <nav class="navbar navbar-dark " style="background-color:#ff5928;">
    <div class="container">
      <span class="navbar-brand mb-0 h1">ระบบเติมเงินผ่าน TrueMoney ด้วย PHP</span>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-12 col-md-5 mx-auto" style="margin-top:40px;">
        <div id="status">
        <p>ต้องมี IP จริงในการรับ Webhook สำหรับตรวจสอบบัตร หากลง ใน localhost ให้ใช้ Ngrok แล้วแก้ url ในไฟล์ tmpay.php</p>
        </div>
        <div class="card">
          <div class="card-header">
            เติมเงิน
          </div>
          <div class="card-body">
           
            <div class="form-group">
              <input type="text" name="user_id" id="user_id" class="form-control" placeholder="UserID">
            </div>
            <div class="form-group">
              <input type="text" name="truemoney_password" id="truemoney_password" class="form-control" maxlength="14" placeholder="กรอกรหัส TrueMoney 14 หลัก">
            </div>
            <button class="btn btn-topup btn-block" id="topup">เติมเงิน</button>

          </div>
        </div>
      </div>
    </div>
  </div>




  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    const pusher = new Pusher('2e583e2d2163c77de2b2', {
      cluster: 'ap1',
      forceTLS: true
    });

    const channel = pusher.subscribe('truemoney');
    channel.bind('topup', (data) => {
      swal("เติมเงินสำเร็จ", data.message, "success");
      setInterval(() => {
        window.location = "index.php"
      }, 1500);
    });

    $("#topup").click(() => {
      $("#topup").prop("disabled", true);
      $("#topup").html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> กำลังตรวจสอบ`
      );

      const truemoney_password = $("#truemoney_password").val()
      const user_id = $("#user_id").val()

      const data = {
        truemoney_password,
        user_id
      }

      $.ajax({
        type: "POST",
        url: 'tmpay.php',
        data: data,
        success: (res) => {
          if (res.status == false) {
            swal("แจ้งเตือน", res.message, "info");
            setInterval(() => {
              window.location = "index.php"
            }, 1500);
          }
        },
      });

    })
  </script>
</body>

</html>