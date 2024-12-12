$(document).ready(function () {
    $(".sidebar-navlink").on("click", function (e) {
        e.preventDefault(); // Prevent default anchor click behavior
        $(".sidebar-navlink").removeClass("link-active"); // Remove active class from all links
        $(this).addClass("link-active"); // Add active class to the clicked link
    
        let url = $(this).attr("href"); // Get the URL from the href attribute
        window.history.pushState({ path: url }, "", url); // Update the browser's URL without reloading
    });

        // Student View

        $("#thesis-list-student").on("click", function (e) {
            e.preventDefault();
            thesisList();
        });
    
        $("#member-list-student").on("click", function (e) {
            e.preventDefault();
            memberList();
        });
    
        $("#track-thesis-student").on("click", function (e) {
            e.preventDefault();
            trackThesis();
        });
        
        $("#request-thesis-student").on("click", function (e) {
            e.preventDefault();
            requestThesis();
        });
        
        
        // Student View

        // Student View

        function thesisList() {
            $.ajax({
              type: "GET",
              url: "../student-view/view-thesis-list.php",
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

                    $("#staff-thesis-list").on("click", ".editThesis", function (e) {
                        e.preventDefault(); // Prevent default behavior
                        editThesisRecord(this.dataset.id); // Call function to add product
                    });
                },
            });
        }

        function editThesisRecord(thesisID) {
            console.log(thesisID);
            $.ajax({
                type: "GET", // Use GET request
                url: "../modals/editThesis-modal.html", // URL to get product data
                dataType: "html", // Expect JSON response
                success: function (view) {
                fetchSpecificThesisData(thesisID);  
                // Assuming 'view' contains the new content you want to display
                $(".modal-container").empty().html(view); // Load the modal view
                $("#editThesisModal").modal("show"); // Show the modal
                $("#editThesisModal").attr("data-id", thesisID);
        
                // Event listener for the add product form submission
                $("#form-edit-thesis").on("submit", function (e) {
                  e.preventDefault(); // Prevent default form submission
                  editThesis(thesisID); // Call function to save product
                });
              },
            });
        }

        function fetchSpecificThesisData(thesisID) {
            $.ajax({
              url: `../student-functions/fetchThesisData.php?id=${thesisID}`, // URL for fetching categories
              type: "POST", // Use GET request
              dataType: "json", // Expect JSON response
              success: function (currThesisData) {
                $("#thesisTitle").val(currThesisData.thesisTitle);
                $("#startDate").val(currThesisData.dateAdded);
              },
            });
        }

        function editThesis(thesisID){
            console.log(thesisID);
            $.ajax({
                type: "POST", // Use POST request
                url: `../student-functions/editThesis.php?id=${thesisID}`, // URL for saving product
                data: $("form").serialize(), // Serialize the form data for submission
                dataType: "json", // Expect JSON response
                success: function (response){
                    if (response.status === "error"){
                        if (response.titleErr) {
                            $("#thesisTitle").addClass("is-invalid"); // Mark field as invalid
                            $("#thesisTitle").next(".invalid-feedback").text(response.titleErr).show(); // Show error message
                        }else{
                            $("#thesisTitle").removeClass("is-invalid"); // Remove invalid class if no error
                        }
    
                        if (response.datePublishedErr) {
                            $("#startDate").addClass("is-invalid"); // Mark field as invalid
                            $("#startDate").next(".invalid-feedback").text(response.datePublishedErr).show(); // Show error message
                        }else{
                            $("#startDate").removeClass("is-invalid"); // Remove invalid class if no error
                        }
                    }else if (response.status === "success") {
                        // On success, hide modal and reset form
                        $("#editThesisModal").modal("hide");
                        $("form")[0].reset(); // Reset the form
                        // Optionally, reload products to show new entry
                        thesisList();
                      }
                }
            })
        }
    
        function memberList() {
            $.ajax({
              type: "GET",
              url: "../student-view/view-member-list.php",
              dataType: "html",
              success: function (response) {
                $("#dashboard-main-display").html(response);
                },
            });
        }
    
        function trackThesis() {
            $.ajax({
              type: "GET",
              url: "../student-view/view-track-thesis.php",
              dataType: "html",
              success: function (response) {
                $("#dashboard-main-display").html(response);
                },
            });
        }
    
        function requestThesis() {
            $.ajax({
              type: "GET",
              url: "../student-view/view-request-thesis.php",
              dataType: "html",
              success: function (response) {
                $("#dashboard-main-display").html(response);
                },
            });
        }
        
        // Student View

    let url = window.location.href;
    if (url.endsWith("thesis-list")) {
        $("#thesis-list-student").trigger("click");
    }else if (url.endsWith("member-list")) {
        $("#member-list-student").trigger("click");
    }else if (url.endsWith("track-thesis")) {
        $("#track-thesis-student").trigger("click");
    }else if (url.endsWith("request-thesis")) {
        $("#request-thesis-student").trigger("click");
    }
});