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
                <tr class="main">
                    <th
                        rowspan=""
                        class="small-width sl-bg"
                    >Sl. No</th>
                    @foreach ($columns as $column)
                        <th rowspan="">{{ $column }}</th>
                    @endforeach
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td class="sl-bg">{{ $loop->iteration }}</td>
                        <td>{{ $data->user->username ?? ' ' }}</td>
                        <td>{{ substr($data->auditable_type, 11) }}</td>
                        <td>{{ $data->auditable_id }}</td>
                        <td>{{ $data->event }}</td>
                        <td>
                            <pre>{{ trim(json_encode($data->old_values, JSON_PRETTY_PRINT), '{}') }}</pre>
                        </td>
                        <td>
                            <pre>{{ trim(json_encode($data->new_values, JSON_PRETTY_PRINT), '{}') }}</pre>
                        </td>
                        <td>{{ $data->ip_address }}</td>
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
        /* width: 100%; */
        /* margin-bottom: 40px; */
    }

    table {
        border-collapse: collapse;
        /* max-width: 100%; */
        width: 100%;
        /* margin: 40px 40px; */
    }

    th[colspan="8"] {
        text-align: center;
        background: rgb(51, 59, 66);
        border: 0.5px solid rgb(51, 59, 66);
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
        /* width: 0em; */
    }

    pre {
        text-align: left;
        font-family: sans-serif;
    }

    td.sl-bg,
    th.sl-bg {
        background: rgb(184, 215, 240);
    }

</style>

</html>
