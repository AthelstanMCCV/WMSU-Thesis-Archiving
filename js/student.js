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
                $("#form-edit-thesis").on("submit", function(e) {
                    e.preventDefault();  // Prevent default form submission
                    console.log("Form submitted via AJAX");  // Debugging message
                    editThesis(thesisID);  // Call the function to submit the form via AJAX
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
                $("#datePublished").val(currThesisData.datePublished);
              },
            });
        }

        function editThesis(thesisID) {
            // Flag to track if there are any validation errors
            let hasErrors = false;
        
            // Clear previous errors
            $(".is-invalid").removeClass("is-invalid");
            $(".invalid-feedback").hide();
        
            // Validate Thesis Title
            let thesisTitle = $("#thesisTitle").val();
            if (!thesisTitle) {
                hasErrors = true;
                $("#thesisTitle").addClass("is-invalid");
                $("#thesisTitle").next(".invalid-feedback").text("Thesis Title is required.").show();
            }
        
            // Validate Date Published
            let datePublished = $("#datePublished").val();
            if (!datePublished) {
                hasErrors = true;
                $("#datePublished").addClass("is-invalid");
                $("#datePublished").next(".invalid-feedback").text("Date Published is required.").show();
            }
        
            // If there are errors, prevent form submission
            if (hasErrors) {
                return false; // This will prevent the form from submitting
            }
        
            // If no errors, proceed with AJAX submission
            $.ajax({
                type: "POST",
                url: `../student-functions/editThesis.php?id=${thesisID}`, // PHP script URL
                data: $("#form-edit-thesis").serialize(), // Serialize form data
                dataType: "json", // Expect JSON response
                success: function (response) {
                    console.log("AJAX Success:", response);
                    if (response.status === "error") {
                        // Handle validation errors again in case of server-side validation
                        if (response.titleErr) {
                            $("#thesisTitle").addClass("is-invalid");
                            $("#thesisTitle").next(".invalid-feedback").text(response.titleErr).show();
                        }
                        if (response.datePublishedErr) {
                            $("#datePublished").addClass("is-invalid");
                            $("#datePublished").next(".invalid-feedback").text(response.datePublishedErr).show();
                        }
                    } else if (response.status === "success") {
                        // Hide the modal and reset the form
                        $("#editThesisModal").modal("hide");
                        $("#form-edit-thesis")[0].reset();
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    }
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    console.error("Response text:", xhr.responseText);
                }
            });
        }
        
        
    
        function memberList() {
            $.ajax({
              type: "GET",
              url: "../student-view/view-member-list.php",
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