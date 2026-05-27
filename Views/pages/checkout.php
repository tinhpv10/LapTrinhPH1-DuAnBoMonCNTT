<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial;
        }

        body{
            background: #f2f2f2;
        }

        .box{
            width: 500px;
            background: white;
            margin: 50px auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1{
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input,
        select{
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button{
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            border: none;
            background: black;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover{
            background: #333;
        }

        .tong{
            margin-top: 20px;
            font-size: 18px;
            text-align: right;
            font-weight: bold;
        }

    </style>

</head>

<body>

    <div class="box">

        <h1>Thanh toán</h1>

        <form>

            <input 
                type="text" 
                placeholder="Họ và tên"
                required
            >

            <input 
                type="text" 
                placeholder="Số điện thoại"
                required
            >

            <input 
                type="text" 
                placeholder="Địa chỉ giao hàng"
                required
            >

            <select>

                <option>
                    Chọn phương thức thanh toán
                </option>

                <option>
                    Thanh toán khi nhận hàng
                </option>

                <option>
                    Chuyển khoản ngân hàng
                </option>

            </select>

            <div class="tong">
                Tổng tiền:
            </div>

            <button>
                Xác nhận thanh toán
            </button>

        </form>

    </div>

</body>

</html>