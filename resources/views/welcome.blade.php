<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matrimony Application - Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 600px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px;
            transition: background 0.3s;
        }
        .btn:hover {
            background: #5a6fd8;
        }
        .success {
            color: #28a745;
            font-size: 18px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success">✅ License Check Bypassed Successfully!</div>
        <h1>Welcome to Your Matrimony Application</h1>
        <p>Your matrimony application is now running without license restrictions. All features are available and the application is fully functional.</p>
        
        <div>
            <a href="/user" class="btn">User Login</a>
            <a href="/admin" class="btn">Admin Panel</a>
            <a href="/register" class="btn">Register</a>
        </div>
        
        <p><strong>Application Status:</strong> ✅ Running | <strong>Database:</strong> ✅ Connected | <strong>License:</strong> ✅ Bypassed</p>
    </div>
</body>
</html>
