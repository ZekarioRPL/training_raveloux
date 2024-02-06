<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
    <style>
        body,
        h1,
        h2,
        h3,
        h4 {
            font-family: 'Inter', 'Roboto';
            color: #000;
        }

        body {
            font-family: 'Inter', 'Roboto';
            font-size: 14px;
        }
    </style>
</head>

<body>
    ​ <div style="max-width: 480px; margin: auto; padding: 40px 20px 80px;">


        <div style="background-color: #fff; border-top: 5px solid #04A4A4; padding: 40px 20px; color:#000;">
            <h2 style="font-size: 16px; margin: 0 0 16px;">New Task Notification</h2>
            <div style="font-size: 16px; margin: 0 0 16px;">{{ $task->created_at->format('d - m - Y') }}</div>

            <table>
                <tr>
                    <td>Title</td>
                    <td>: {{ $task->title }}</td>
                </tr>
                <tr>
                    <td>Responsible</td>
                    <td>: {{ $task->user_name }}</td>
                </tr>
                <tr>
                    <td>Project</td>
                    <td>: {{ $task->project_name }}</td>
                </tr>
                <tr>
                    <td>Client</td>
                    <td>: {{ $task->contact_name }}</td>
                </tr>
                <tr>
                    <td>Deadline</td>
                    <td>: {{ $task->deadline }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>: <strong>{{ $task->status }}</strong></td>
                </tr>
                <tr>
                    <td>description</td>
                    <td>: {{ $task->description }}</td>
                </tr>
            </table>

            <div
                style="display: block;width:100%;text-align:center;line-height: 20px;padding:6px 0;color:#fff;background:#00a1b0;font-weight:500;font-size:14px;border-radius:3px;margin: 0 0 16px;">
                <a href="{{ Route('task.index') }}" style="text-decoration: none; color:#fff;">View task in
                    website</a>
            </div>


            <div style="margin: 0 0 16px;"></div>

        </div>
        ​
    </div>

</body>

</html>
