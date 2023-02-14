<table>
    <thead>
    <tr>
        <th>Country</th>
        <th>Partner ID</th>
        <th>Partner Name</th>
        <th>Start period</th>
        <th>End period</th>
        <th>HP Product Number</th>
        <th>Total Sellin Units</th>
        <th>Inventory Units</th>
        <th>Sales Units</th>
        <th>Transaction Date</th>
        <th>Channel Partner to Customer Invoice ID</th>

        <th>Sold-to Customer ID</th>
        <th>Sold To Customer Name</th>
        <th>Sold To Company Tax ID</th>
        <th>Sold To Address Line 1</th>
        <th>Sold To Address Line 2</th>
        <th>Sold To City</th>
        <th>Sold To Postal Code</th>
        <th>Sold To Country Code</th>

        <th>Ship-to Customer ID</th>
        <th>Ship To Customer Name</th>
        <th>Ship To Company Tax ID</th>
        <th>Ship To Address Line 1</th>
        <th>Ship To Address Line 2</th>
        <th>Ship To City</th>
        <th>Ship To Postal Code</th>
        <th>Ship To Country Code</th>

        <th>Online</th>
        <th>Customer Online Order Date</th>
        <th>Sell From ID</th>
        <th>Product Serial ID assigned by HP</th>

        <th>Deal/Promo ID #1</th>
        <th>Bundle ID #1</th>
        <th>Deal/Promo ID #2</th>
        <th>Bundle ID#2</th>
        <th>Deal/Promo ID #3</th>
        <th>Bundle ID#3</th>
        <th>Deal/Promo ID #4</th>
        <th>Bundle ID#4</th>
        <th>Deal/Promo ID #5</th>
        <th>Bundle ID#5</th>
        <th>Deal/Promo ID #6</th>
        <th>Bundle ID#6</th>

        <th>Contract ID</th>
        <th>Contract start date</th>
        <th>Contract end date</th>
        <th>Drop ship Flag</th>
        <th>Partner Internal transaction ID</th>
        <th>Partner Requested Rebate Amount</th>
        <th>Partner Reference</th>
        <th>Partner Comment</th>
        <th>Partner Product Name</th>
    </tr>
    </thead>
    <tbody>

    @foreach($report as $row)
        <tr>
            <td>{{ $row->{'Country'} }}</td>
            <td>{{ $row->{'Partner ID'} }}</td>
            <td>{{ $row->{'Partner Name'} }}</td>
            <td>{{ $row->{'Start period'} }}</td>
            <td>{{ $row->{'End period'} }}</td>
            <td>{{ $row->{'HP Product Number'} }}</td>
            <td>{{ $row->{'Total Sellin Units'} }}</td>
            <td>{{ $row->{'Inventory Units'} }}</td>
            <td>{{ $row->{'Sales Units'} }}</td>
            <td>{{ $row->{'Transaction Date'} }}</td>
            <td>{{ $row->{'Channel Partner to Customer Invoice ID'} }}</td>

            <td>{{ $row->{'Sold-to Customer ID'} }}</td>
            <td>{{ $row->{'Sold To Customer Name'} }}</td>
            <td>{{ $row->{'Sold To Company Tax ID'} }}</td>
            <td>{{ $row->{'Sold To Address Line 1'} }}</td>
            <td>{{ $row->{'Sold To Address Line 2'} }}</td>
            <td>{{ $row->{'Sold To City'} }}</td>
            <td>{{ $row->{'Sold To Postal Code'} }}</td>
            <td>{{ $row->{'Sold To Country Code'} }}</td>

            <td>{{ $row->{'Ship-to Customer ID'} }}</td>
            <td>{{ $row->{'Ship To Customer Name'} }}</td>
            <td>{{ $row->{'Ship To Company Tax ID'} }}</td>
            <td>{{ $row->{'Ship To Address Line 1'} }}</td>
            <td>{{ $row->{'Ship To Address Line 2'} }}</td>
            <td>{{ $row->{'Ship To City'} }}</td>
            <td>{{ $row->{'Ship To Postal Code'} }}</td>
            <td>{{ $row->{'Ship To Country Code'} }}</td>

            <td>{{ $row->{'Online'} }}</td>
            <td>{{ $row->{'Customer Online Order Date'} }}</td>
            <td>{{ $row->{'Sell From ID'} }}</td>
            <td>{{ $row->{'Product Serial ID assigned by HP'} }}</td>

            <td>{{ $row->{'Deal/Promo ID #1'} }}</td>
            <td>{{ $row->{'Bundle ID #1'} }}</td>
            <td>{{ $row->{'Deal/Promo ID #2'} }}</td>
            <td>{{ $row->{'Bundle ID #2'} }}</td>
            <td>{{ $row->{'Deal/Promo ID #3'} }}</td>
            <td>{{ $row->{'Bundle ID #3'} }}</td>
            <td>{{ $row->{'Deal/Promo ID #4'} }}</td>
            <td>{{ $row->{'Bundle ID #4'} }}</td>
            <td>{{ $row->{'Deal/Promo ID #5'} }}</td>
            <td>{{ $row->{'Bundle ID #5'} }}</td>
            <td>{{ $row->{'Deal/Promo ID #6'} }}</td>
            <td>{{ $row->{'Bundle ID #6'} }}</td>

            <td>{{ $row->{'Contract ID'} }}</td>
            <td>{{ $row->{'Contract start date'} }}</td>
            <td>{{ $row->{'Contract end date'} }}</td>
            <td>{{ $row->{'Drop ship Flag'} }}</td>
            <td>{{ $row->{'Partner Internal transaction ID'} }}</td>
            <td>{{ $row->{'Partner Requested Rebate Amount'} }}</td>
            <td>{{ $row->{'Partner Reference'} }}</td>
            <td>{{ $row->{'Partner Comment'} }}</td>
            <td>{{ $row->{'Partner Product Name'} }}</td>
    @endforeach
    </tbody>
</table>
