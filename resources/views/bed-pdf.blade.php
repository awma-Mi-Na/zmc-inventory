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
                    <th colspan="10">
                        <p>ZMC-SRHF</p>
                        <p>{{ $title }}</p>
                        <p>DATE: {{ $date }}</p>
                    </th>
                </tr>
                <tr class="main">
                    <th
                        rowspan="2"
                        class="small-width sl-bg"
                    >Sl. No</th>
                    @foreach ($columns as $column)
                        <th rowspan="2">{{ $column }}</th>
                    @endforeach
                    <th colspan="2">ON VENTILATOR</th>
                </tr>
                <tr>
                    <th>INVASIVE</th>
                    <th>NIV</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td class="sl-bg">{{ $loop->iteration }}</td>
                        <td class="align-left">{{ $data->item->name }}</td>
                        <td>{{ $data->total }}</td>
                        <td>{{ $data->patients }}</td>
                        <td>{{ $data->attendants }}</td>
                        <td>{{ $data->positive_attendants }}</td>
                        <td>{{ $data->empty }}</td>
                        <td>{{ $data->on_oxygen }}</td>
                        <td>{{ $data->on_ventilator_invasive }}</td>
                        <td>{{ $data->on_ventilator_niv }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td></td>
                    <td style="background: rgb(87, 179, 240);">Total</td>
                    @foreach ($sums as $key => $value)
                        <td style="background: rgb(87, 179, 240);">{{ $value }}</td>
                    @endforeach
                </tr>
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
        width: 100%;
    }

    table {
        border-collapse: collapse;
    }

    th[colspan="10"] {
        text-align: center;
        background: rgb(116, 90, 187);
        border: 0.5px solid rgb(116, 90, 187);
        border-bottom: 0;
        padding: 0;
        color: white;
        font-weight: normal;
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

    tr.main>th:nth-child(2) {
        width: 20em;
    }

    td.sl-bg,
    th.sl-bg {
        background: rgb(172, 217, 255);
    }

    td:empty {
        border: none;
    }

</style>

</html>
