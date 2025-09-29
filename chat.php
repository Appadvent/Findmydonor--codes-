<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chat Layout</title>
    <style>

        .wkdo-chat-container {
            width: 350px;
            height: 500px;
            display: flex;
            flex-direction: column;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            background: #fff;
        }
        .wkdo-chat-header {
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 18px;
        }
        .wkdo-chat-body {
            flex: 1;
            padding: 10px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        .wkdo-message {
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            max-width: 70%;
        }
        .wkdo-sent {
            align-self: flex-end;
            background: #007bff;
            color: white;
        }
        .wkdo-received {
            align-self: flex-start;
            background: #e0e0e0;
        }
        .wkdo-chat-footer {
            display: flex;
            padding: 10px;
            background: #f1f1f1;
            border-top: 1px solid #ccc;
        }
        .wkdo-chat-footer input {
            flex: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }
        .wkdo-chat-footer button {
            padding: 10px 15px;
            margin-left: 5px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="wkdo-chat-container">
        <div class="wkdo-chat-header">Chat</div>
        <div class="wkdo-chat-body">
            <div class="wkdo-message wkdo-received">Hello! How are you?</div>
            <div class="wkdo-message wkdo-sent">I'm good, thanks! How about you?</div>
        </div>
        <div class="wkdo-chat-footer">
            <input type="text" placeholder="Type a message...">
            <button>Send</button>
        </div>
    </div>
</body>
</html>
