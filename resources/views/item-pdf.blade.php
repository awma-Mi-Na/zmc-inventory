<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title }}</title>
</head>

<body>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th colspan="8">
                        <p>ZMC-SRHF</p>
                        <p>{{ $title }}</p>
                        <p>DATE: {{ $date }}</p>
                    </th>
                </tr>
                <tr>
                    <th class="small-width sl-bg">Sl. No</th>
                    @foreach ($columns as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td class="sl-bg">{{ $loop->iteration }}</td>
                        <td class="align-left">{{ $data->item->name }}</td>
                        <td>{{ $data->cumulative_stock }}</td>
                        <td>{{ $data->opening_balance }}</td>
                        <td>{{ $data->received }}</td>
                        <td>{{ $data->total }}</td>
                        <td>{{ $data->issued }}</td>
                        <td>{{ $data->closing_balance }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
<style>
    body {
        font-family: 'Arial Narrow Bold', sans-serif;
        font-size: 14px;
    }

    .table-wrapper {
        display: flex;
        justify-content: center;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th[colspan] {
        text-align: center;
        background: rgb(116, 90, 187);
        border: 0.5px solid rgb(116, 90, 187);
        border-bottom: 0;
        padding: 0;
        color: white;
        font-weight: normal;
        width: 100vw;
    }

    th.small-width {
        width: 1.5em;
    }

    th>p {
        margin: 0.5em;
    }

    td,
    th {
        border: 0.5px solid black;
        padding: 0.5em;
    }

    td {
        font-size: 13px;
        padding: 0.2em 0.2em;
        text-align: center;
        word-break: break-all;
    }

    td.align-left {
        text-align: left;
    }

    th:nth-child(2) {
        width: 30em;
    }

    td.sl-bg,
    th.sl-bg {
        background: rgb(172, 217, 255);
    }

</style>

</html>
