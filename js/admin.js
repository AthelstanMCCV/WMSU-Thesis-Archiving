$(document).ready(function () {
    $(".sidebar-navlink").on("click", function (e) {
        e.preventDefault(); // Prevent default anchor click behavior
        $(".sidebar-navlink").removeClass("link-active"); // Remove active class from all links
        $(this).addClass("link-active"); // Add active class to the clicked link
    
        let url = $(this).attr("href"); // Get the URL from the href attribute
        window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
    });

    $("#intro-img").on("click", function (e) {
        e.preventDefault();
        Logout();
    });

    $("#pending-request-admin").on("click", function (e) {
        e.preventDefault();
        pendingRequest();
    });

    $("#group-list-admin").on("click", function (e) {
        e.preventDefault();
        groupList();
    });

    $("#thesis-archives-admin").on("click", function (e) {
        e.preventDefault();
        thesisArchives();
    });

    $(document).on("click", ".approve", function (e) {
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
            url: "../admin-functions/approve.php", // PHP script to handle approval
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

    $(document).on("click", ".reject", function (e) {
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
    
    // Handle the modal's Reject button
    $(document).on("click", ".confirmReject", function () {
        const id = $(this).data("id"); // Get the ID from the Confirm button
    
        // AJAX request to approve the account
        $.ajax({
            type: "GET",
            url: "../admin-functions/reject.php", // PHP script to handle approval
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

    function Logout() {
        $.ajax({
        type: "GET",
        url: "../modals/navbar-modal.html",
        dataType: "html",
            success: function (view) {
                $(".modal-container").empty().html(view);
                $("#logoutModal").modal("show");
            },
            });
        };

    function pendingRequest() {
        $.ajax({
          type: "GET",
          url: "../admin-view/view-pending-students.php",
          dataType: "html",
          success: function (response)
            {
                $("#dashboard-main-display").html(response);

                var table = $("#pending-students-table").DataTable({
                    dom: "irtp", // Set DataTable options
                    pageLength: 6, // Default page length
                    ordering: false, // Disable ordering
                });

                $("#pending-search").on("keyup", function () {
                    table.search(this.value).draw(); // Search products based on input
                  });
            },
        });
    }

    function groupList() {
        $.ajax({
          type: "GET",
          url: "../admin-view/view-groupList.php",
          dataType: "html",
          success: function (response) {
                $("#dashboard-main-display").html(response);
                
                var table = $("#group-list").DataTable({
                    dom: "irtp", // Set DataTable options
                    pageLength: 6, // Default page length
                    ordering: false, // Disable ordering
                });

                $("#group-search").on("keyup", function () {
                    table.search(this.value).draw(); // Search products based on input
                });
            },
        });
    }

    function thesisArchives() {
        $.ajax({
          type: "GET",
          url: "../admin-view/view-thesis-archives.php",
          dataType: "html",
          success: function (response) {
                $("#dashboard-main-display").html(response);

                var table = $("#archives-table").DataTable({
                    dom: "irtp", // Set DataTable options
                    pageLength: 6, // Default page length
                    ordering: false, // Disable ordering
                });

                $("#archive-search").on("keyup", function () {
                    table.search(this.value).draw(); // Search products based on input
                });

            },
        });
    }

    let url = window.location.href;
    if (url.endsWith("pending-students")) {
        $("#pending-request-admin").trigger("click");
    } else if (url.endsWith("groupList")) {
        $("#group-list-admin").trigger("click");
    } else if (url.endsWith("thesis-archives")) {
        $("#thesis-archives-admin").trigger("click");
    }
});