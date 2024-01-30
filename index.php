
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Data</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0 10%;
    padding: 0;
}

h1 {
    text-align: center;
    margin-top: 10px;
    padding-top: 5%;
}



#pagination {
    text-align: center;
    margin-top: 20px;
}

#pagination button {
    margin: 0 5px;
    padding: 5px 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    cursor: pointer;
}
#contactList {
    border-collapse: collapse;
    width: 100%;
}

#contactList th, #contactList td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}

#contactList th {
    background-color: #f2f2f2;
}

#contactList tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}



#pagination button:hover {
    background-color: #f0f0f0;
}
#contactList {
    margin: 5rem auto;
}
 h1 {
            text-align: center;
            margin-top: 20px;
        }

         ul {
        
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: flex-end;
        }

        ul li {
            margin-left: 10px; 
        }

        ul li a {
            text-decoration: none;
            color: #333;
        }

        ul li a:hover {
            color: #007bff;
        }
        ul li button {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }


    </style>
</head>
<body>
   <h1>Contact List</h1>
   <ul>
    <li>
     <a href="contact.php">Add Contact</a> |
     <a href="index.php">Contacts</a> |
     <form method="post">
        <button type="submit" name="logout">Logout</button>
     </form>
    </li>
   </ul>
<table id="contactList">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Company</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="read"></tbody>
</table>
<div id="pagination"></div>

   <script>
$(document).ready(function() {
    function fetchContactData(page) {
        $.ajax({
            url: 'search.php',
            type: 'GET',
            dataType: 'json',
            data: { page: page },
            success: function(response) {
                $('#contactList tbody').empty(); 


                response.data.forEach(function(contact) {
                    $('#contactList tbody').append('<tr style="background-color: #f9f9f9;">' +
                            '<td style="padding: 8px;">' + contact.firstname + '</td>' +
                            '<td style="padding: 8px;">' + contact.email + '</td>' +
                            '<td style="padding: 8px;">' + contact.company + '</td>' +
                            '<td style="padding: 8px;">' + contact.phone + '</td>' +
                            '<td style="padding: 8px;"><button class="deleteBtn" data-id="' + contact.id + '" style="background-color: #ff0000; color: #fff; border: none; padding: 5px 10px; border-radius: 5px;">Delete</button> | <button class="editBtn" style="background-color: #4caf50; color: #fff; border: none; padding: 5px 10px; border-radius: 5px;">Edit</button></td>' +
                            '</tr>');
                });

                $('#pagination').empty();
                for (var i = 1; i <= response.totalPages; i++) {
                    $('#pagination').append('<button class="pageBtn" data-page="' + i + '">' + i + '</button>');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

  $(document).on('click', '.deleteBtn', function() {

        var contactId = $(this).data('id');
        

        if (confirm('Are you sure you want to delete this contact?')) {

            $.ajax({
                url: 'delete.php',
                type: 'POST',
                dataType: 'json',
                data: { id: contactId },
                success: function(response) {
          
                    if (response.success) {
  
                        fetchContactData(1);
                    } else {
   
                        alert('Failed to delete contact.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });

    $(document).on('click', '.pageBtn', function(e) {
        e.preventDefault();
        var page = $(this).data('page');
        fetchContactData(page);
    });

    fetchContactData(1);
});
</script>

</body>
</html>