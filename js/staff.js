$(document).ready(function () {
    $(".sidebar-navlink").on("click", function (e) {
        e.preventDefault(); // Prevent default anchor click behavior
        $(".sidebar-navlink").removeClass("link-active"); // Remove active class from all links
        $(this).addClass("link-active"); // Add active class to the clicked link
    
        let url = $(this).attr("href"); // Get the URL from the href attribute
        window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
    });

    $("#thesis-list-staff").on("click", function (e) {
        e.preventDefault();
        viewStaff();
    });

    $("#thesis-logs-staff").on("click", function (e) {
        e.preventDefault();
        thesisLogs();
    });

    $("#staff-list").on("click", function (e) {
        e.preventDefault();
        staffList();
    });

    $("#staff-action").on("click", function (e) {
        e.preventDefault();
        staffAction();
    });

    function viewStaff() {
        $.ajax({
          type: "GET",
          url: "../staff-view/view-staff-thesis-list.php",
          dataType: "html",
          success: function (response) {
            $("#dashboard-main-display").html(response);
                var table = $("#staff-thesis-list").DataTable({
                    dom: "rtp", // Set DataTable options
                    pageLength: 10, // Default page length
                    ordering: false, // Disable ordering
                });

                $("#staff-thesis-search").on("keyup", function () {
                    table.search(this.value).draw(); // Search products based on input
                });
            },
        });
    }

    function thesisLogs() {
        $.ajax({
          type: "GET",
          url: "../staff-view/view-staff-thesis-logs.php",
          dataType: "html",
          success: function (response) {
            $("#dashboard-main-display").html(response);
                var table = $("#staff-thesis-list").DataTable({
                    dom: "rtp", // Set DataTable options
                    pageLength: 10, // Default page length
                    ordering: false, // Disable ordering
                });

                $("#staff-thesis-search").on("keyup", function () {
                    table.search(this.value).draw(); // Search products based on input
                });
            },
        });
    }

    function staffAction() {
        $.ajax({
          type: "GET",
          url: "../staff-view/view-staff-action.php",
          dataType: "html",
          success: function (response) {
            $("#dashboard-main-display").html(response);
                var table = $("#staff-thesis-list").DataTable({
                    dom: "rtp", // Set DataTable options
                    pageLength: 10, // Default page length
                    ordering: false, // Disable ordering
                });

                $("#staff-thesis-search").on("keyup", function () {
                    table.search(this.value).draw(); // Search products based on input
                });
            },
        });
    }

    function staffList() {
        $.ajax({
          type: "GET",
          url: "../staff-view/view-staff-list.php",
          dataType: "html",
          success: function (response) {
            $("#dashboard-main-display").html(response);
                var table = $("#staff-thesis-list").DataTable({
                    dom: "rtp", // Set DataTable options
                    pageLength: 10, // Default page length
                    ordering: false, // Disable ordering
                });

                $("#staff-thesis-search").on("keyup", function () {
                    table.search(this.value).draw(); // Search products based on input
                });

                $("#addStaff").on("click", function (e) {
                    e.preventDefault();
                    addStaffModal();
                });

                $(".editStaff").on("click", function (e) {
                    e.preventDefault(); // Prevent default behavior
                    editStaffRecord(this.dataset.id); // Call function to add product
                });
            
                function addStaffModal() {
                    $.ajax({
                    type: "GET",
                    url: "../modals/addStaff-modal.html",
                    dataType: "html",
                        success: function (view) {
                            $(".modal-container").empty().html(view);
                            $("#addStaffModal").modal("show");

                            $("#form-add-staff").on("submit", function (e) {
                                e.preventDefault(); // Prevent default form submission
                                addStaff(); // Call function to save product
                              });
                        },
                        });
                };

                function editStaffRecord(staffID) {
                    $.ajax({
                      type: "GET", // Use GET request
                      url: "../modals/editStaff-modal.html", // URL to get product data
                      dataType: "html", // Expect JSON response
                      success: function (view) {
                        fetchSpecificStaffData(staffID);
                        // Assuming 'view' contains the new content you want to display
                        $(".modal-container").empty().html(view); // Load the modal view
                        $("#editStaffModal").modal("show"); // Show the modal
                        $("#editStaffModal").attr("data-id", staffID);
                
                        // Event listener for the add product form submission
                        $("#form-edit-staff").on("submit", function (e) {
                          e.preventDefault(); // Prevent default form submission
                          editStaff(staffID); // Call function to save product
                        });
                      },
                    });
                  }
                
            },
        });
    }

    function addStaff(){
        $.ajax({
            type: "POST", // Use POST request
            url: "../staff-functions/addStaff.php", // URL for saving product
            data: $("form").serialize(), // Serialize the form data for submission
            dataType: "json", // Expect JSON response
            success: function (response){
                if (response.status === "error"){
                    if (response.usernameErr) {
                        $("#username").addClass("is-invalid"); // Mark field as invalid
                        $("#username").next(".invalid-feedback").text(response.usernameErr).show(); // Show error message
                    }else{
                        $("#username").removeClass("is-invalid"); // Remove invalid class if no error
                    }

                    if (response.passwordErr) {
                        $("#password").addClass("is-invalid"); // Mark field as invalid
                        $("#password").next(".invalid-feedback").text(response.passwordErr).show(); // Show error message
                    }else{
                        $("#password").removeClass("is-invalid"); // Remove invalid class if no error
                    }

                    if (response.emailErr) {
                        $("#Email").addClass("is-invalid"); // Mark field as invalid
                        $("#Email").next(".invalid-feedback").text(response.emailErr).show(); // Show error message
                    }else{
                        $("#Email").removeClass("is-invalid"); // Remove invalid class if no error
                    }
                }else if (response.status === "success") {
                    // On success, hide modal and reset form
                    $("#addStaffModal").modal("hide");
                    $("form")[0].reset(); // Reset the form
                    // Optionally, reload products to show new entry
                    staffList();
                  }
            }
        })
    }

    function editStaff(staffID){
        console.log(staffID);
        $.ajax({
            type: "POST", // Use POST request
            url: `../staff-functions/editStaffAcc.php?id=${staffID}`, // URL for saving product
            data: $("form").serialize(), // Serialize the form data for submission
            dataType: "json", // Expect JSON response
            success: function (response){
                if (response.status === "error"){
                    if (response.usernameErr) {
                        $("#username").addClass("is-invalid"); // Mark field as invalid
                        $("#username").next(".invalid-feedback").text(response.usernameErr).show(); // Show error message
                    }else{
                        $("#username").removeClass("is-invalid"); // Remove invalid class if no error
                    }

                    if (response.passwordErr) {
                        $("#password").addClass("is-invalid"); // Mark field as invalid
                        $("#password").next(".invalid-feedback").text(response.passwordErr).show(); // Show error message
                    }else{
                        $("#password").removeClass("is-invalid"); // Remove invalid class if no error
                    }

                    if (response.emailErr) {
                        $("#Email").addClass("is-invalid"); // Mark field as invalid
                        $("#Email").next(".invalid-feedback").text(response.emailErr).show(); // Show error message
                    }else{
                        $("#Email").removeClass("is-invalid"); // Remove invalid class if no error
                    }
                }else if (response.status === "success") {
                    // On success, hide modal and reset form
                    $("#editStaffModal").modal("hide");
                    $("form")[0].reset(); // Reset the form
                    // Optionally, reload products to show new entry
                    staffList();
                  }
            }
        })
    }
    
    $(document).on("click", ".staffApprove", function (e) {
        e.preventDefault();
    
        // Get the ID from the clicked button
        const id = $(this).data("id");
    
        // Load the modal
        $.ajax({
            type: "GET",
            url: "../modals/confirmation-modal.html", // Path to the modal's HTML
            dataType: "html",
            success: function (view) {
                $(".modal-container").empty().html(view); // Load modal content
                $(".confirmApprove").data("id", id); // Pass the ID to the Confirm button
                $("#confirmModal").modal("show"); // Show the modal
            },
            error: function () {
                console.error("Failed to load modal.");
            },
        });
    });

    $(document).on("click", ".approveReq", function (e) {
        e.preventDefault();
    
        // Get the ID from the clicked button
        const id = $(this).data("id");
    
        // Load the modal
        $.ajax({
            type: "GET",
            url: "../modals/confirmation-modal.html", // Path to the modal's HTML
            dataType: "html",
            success: function (view) {
                $(".modal-container").empty().html(view); // Load modal content
                $(".confirmApprove").data("id", id); // Pass the ID to the Confirm button
                $("#confirmModal").modal("show"); // Show the modal
            },
            error: function () {
                console.error("Failed to load modal.");
            },
        });
    });

    // Handle the modal's Confirm button
    $(document).on("click", ".confirmApprove", function () {
        const id = $(this).data("id"); // Get the ID from the Confirm button
    
        // AJAX request to approve the account
        $.ajax({
            type: "GET",
            url: "../staff-functions/confirm.php", // PHP script to handle approval
            data: { id: id }, // Pass the ID as a parameter
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#response").text(response.message); // Show success message
                    // Optionally remove the approved row
                    $(`tr[data-id='${id}']`).remove();
                } else {
                    $("#response").text(response.message); // Show error message
                }
                $("#confirmModal").modal("hide"); // Close the modal
                location.reload();
            },
            error: function () {
                $("#response").text("Error processing the request."); // Handle AJAX errors
                $("#confirmModal").modal("hide"); // Close the modal
                location.reload();
            },
        });
    });
    
    // Handle the modal's Confirm button
    $(document).on("click", ".confirmApprove", function () {
        const id = $(this).data("id"); // Get the ID from the Confirm button
    
        // AJAX request to approve the account
        $.ajax({
            type: "GET",
            url: "../staff-functions/approveThesis.php", // PHP script to handle approval
            data: { id: id }, // Pass the ID as a parameter
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#response").text(response.message); // Show success message
                    // Optionally remove the approved row
                    $(`tr[data-id='${id}']`).remove();
                } else {
                    $("#response").text(response.message); // Show error message
                }
                $("#confirmModal").modal("hide"); // Close the modal
            },
            error: function () {
                $("#response").text("Error processing the request."); // Handle AJAX errors
                $("#confirmModal").modal("hide"); // Close the modal
            },
        });
    });

    $(document).on("click", ".staffReject", function (e) {
        e.preventDefault();
    
        // Get the ID from the clicked button
        const id = $(this).data("id");
    
        // Load the modal
        $.ajax({
            type: "GET",
            url: "../modals/rejection-modal.html", // Path to the modal's HTML
            dataType: "html",
            success: function (view) {
                $(".modal-container").empty().html(view); // Load modal content
                $(".confirmReject").data("id", id); // Pass the ID to the Reject button
                $("#rejectModal").modal("show"); // Show the modal
            },
            error: function () {
                console.error("Failed to load modal.");
            },
        });
    });

    $(document).on("click", ".denyReq", function (e) {
        e.preventDefault();
    
        // Get the ID from the clicked button
        const id = $(this).data("id");
    
        // Load the modal
        $.ajax({
            type: "GET",
            url: "../modals/rejection-modal.html", // Path to the modal's HTML
            dataType: "html",
            success: function (view) {
                $(".modal-container").empty().html(view); // Load modal content
                $(".confirmReject").data("id", id); // Pass the ID to the Reject button
                $("#rejectModal").modal("show"); // Show the modal
            },
            error: function () {
                console.error("Failed to load modal.");
            },
        });
        // Handle the modal's Reject button
        $(document).on("click", ".confirmReject", function () {
        const id = $(this).data("id"); // Get the ID from the Confirm button
    
        // AJAX request to approve the account
            $.ajax({
                type: "GET",
                url: "../staff-functions/deny.php", // PHP script to handle approval
                data: { id: id }, // Pass the ID as a parameter
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#response").text(response.message); // Show success message
                        // Optionally remove the approved row
                        $(`tr[data-id='${id}']`).remove();
                    } else {
                        $("#response").text(response.message); // Show error message
                    }
                    $("#rejectModal").modal("hide"); // Close the modal
                },
                error: function () {
                    $("#response").text("Error processing the request."); // Handle AJAX errors
                    $("#rejectModal").modal("hide"); // Close the modal
                },
            });
        });
    });
    
    // Handle the modal's Reject button
    $(document).on("click", ".confirmReject", function () {
        const id = $(this).data("id"); // Get the ID from the Confirm button
    
        // AJAX request to approve the account
        $.ajax({
            type: "GET",
            url: "../staff-functions/rejectThesis.php", // PHP script to handle approval
            data: { id: id }, // Pass the ID as a parameter
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#response").text(response.message); // Show success message
                    // Optionally remove the approved row
                    $(`tr[data-id='${id}']`).remove();
                } else {
                    $("#response").text(response.message); // Show error message
                }
                $("#rejectModal").modal("hide"); // Close the modal
            },
            error: function () {
                $("#response").text("Error processing the request."); // Handle AJAX errors
                $("#rejectModal").modal("hide"); // Close the modal
            },
        });
    });

    $(document).on("click", ".deleteStaff", function (e) {
        e.preventDefault();
    
        // Get the ID from the clicked button
        const id = $(this).data("id");
    
        // Load the modal
        $.ajax({
            type: "GET",
            url: "../modals/deletion-modal.html", // Path to the modal's HTML
            dataType: "html",
            success: function (view) {
                $(".modal-container").empty().html(view); // Load modal content
                $(".confirmDelete").data("id", id); // Pass the ID to the Reject button
                $("#deleteModal").modal("show"); // Show the modal
                console.log(id);
            },
            error: function () {
                console.error("Failed to load modal.");
            },
        });
    });
    
    // Handle the modal's Reject button
    $(document).on("click", ".confirmDelete", function () {
        const id = $(this).data("id"); // Get the ID from the Confirm button
    
        // AJAX request to approve the account
        $.ajax({
            type: "GET",
            url: "../staff-functions/deleteStaffAcc.php", // PHP script to handle approval
            data: { id: id }, // Pass the ID as a parameter
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    $("#response").text(response.message); // Show success message
                    // Optionally remove the approved row
                    $(`tr[data-id='${id}']`).remove();
                } else {
                    $("#response").text(response.message); // Show error message
                }
                $("#deleteModal").modal("hide"); // Close the modal
                location.reload();
            },
            error: function () {
                $("#response").text("Error processing the request."); // Handle AJAX errors
                $("#deleteModal").modal("hide"); // Close the modal
                location.reload();
            },
        });
    });

    function fetchSpecificStaffData(staffID) {
        $.ajax({
          url: `../staff-functions/fetchStaffData.php?id=${staffID}`, // URL for fetching categories
          type: "POST", // Use GET request
          dataType: "json", // Expect JSON response
          success: function (record) {
            $("#username").val(record.username);
            $("#Email").val(record.email);
          },
        });
    }

    let url = window.location.href;
    if (url.endsWith("staff-thesis-list")) {
        $("#thesis-list-staff").trigger("click");
    }else if (url.endsWith("staff-thesis-logs")) {
        $("#thesis-logs-staff").trigger("click");
    }else if (url.endsWith("staff-list")) {
        $("#staff-list").trigger("click");
    }else if (url.endsWith("staff-action-req")) {
        $("#staff-action").trigger("click");
    }


});