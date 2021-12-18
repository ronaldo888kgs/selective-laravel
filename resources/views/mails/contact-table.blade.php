

<table 
    class="table table-bordered table-row-dashed table-striped table-row-gray-300 align-middle gs-0 gy-4" 
    style=" font-size:14px; ">
    <thead class="table-light" >
        <th style="width:30px; background-color:#484848 !important">
            <input type="checkbox" name="sendAllCheck" id="sendAllCheck" onchange="checkAllAddress()">
        </th>
        <th style="background-color:#484848 !important; color:white">Name</th>
        <th style="background-color:#484848 !important; color:white">Email</th>
        <th style="background-color:#484848 !important; color:white">Telegram ID</th>
        <th style="background-color:#484848 !important; color:white">Discord ID</th>
        <th style="background-color:#484848 !important; color:white">Twitter ID</th>
        <th style="background-color:#484848 !important; color:white">Slack ID</th>
        <th style="background-color:#484848 !important; color:white">Mobile Number</th>
        <th style="background-color:#484848 !important; color:white">Actions</th>
    </thead>
    <tbody>
        @foreach ( $contacts as $contact )
        <tr>
            <td><input type="checkbox" name="checkMailer" value="{{ $contact->id }}"></td>
            <td> {{ $contact->first_name }} {{ $contact->last_name }}</td>
            <td> 
                {{ $contact->email }}
                <input type="hidden" name="hidden_emails" id="hidden_emails" value="{{ $contact->email }}">
            </td>
            <td>{{ $contact->telegram_id }}</td>
            <td>{{ $contact->discord_id }}</td>
            <td>{{ $contact->twitter_id }}</td>
            <td>{{ $contact->slack_id }}</td>
            <td>{{ $contact->phone }}</td>
            <td class="d-flex justify-content-center">
                <a 
                    data-toggle="tooltip" 
                    title="Delete record" 
                    style="cursor: pointer;" 
                    data-bs-toggle="modal" 
                    data-bs-target="#newMailerModal" 
                    onclick="showDeleteModal('{{ $contact }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $contacts->withQueryString()->links() }}