console.log('workstation.js loading');
var Child_url = '/settings/workstation_configure?';

$(document).ready(function() {
  $('#btnCreateNew').text('Create New Workstation').on('click', function() {
    location.href = "/settings/workstation_configure";
  });

  var table = $('#tableworkstation').DataTable({
    responsive: true,
    columnDefs: [{
      targets: [0, 1, 2],
      className: "text-center"
    }],
    order: [],
    columns: [
      { data: "thId", width: "20%" },
      { data: "thworkstation", width: "40%" },
      { data: "action", width: "40%" }
    ]
  });

  loadWorkstations();
});

function loadWorkstations() {
  $.ajax({
    type: 'GET',
    url: '/settings/workstation/loadWorkstations',
    success: function(response) {
      console.log(response.result);
      if (response.success) {
        var data = response.result.map(function(item) {
          return {
            thId: item.id,
            thworkstation: item.WorkstationName,
            index: item.list_index,
            action: `<button class="btn btn-primary mr-1" onclick="edit(${item.id})"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                     <button class="btn btn-danger mr-1" onclick="_delete(${item.id})"><i class="fa fa-trash" aria-hidden="true"></i></button>`
          };
        });

        $('#tableworkstation').DataTable().clear().rows.add(data).draw();
      }
    },
    error: function(data) {
      console.log('Something went wrong');
    }
  });
}

function _delete(id) {
  $.ajax({
    type: 'DELETE',
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    url: `/settings/workstation/delete/${id}`,
    success: function(response) {
      console.log(response);
      if (response.success) {
        toastr.success(response.message);
        loadWorkstations();
      }
    },
    error: function(data) {
      console.log(data);
    }
  });
}

function edit(id) {
  location.href = Child_url + id;
}
