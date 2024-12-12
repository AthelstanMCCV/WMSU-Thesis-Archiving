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
                        dom: "irtp", // Set DataTable options
                        pageLength: 6, // Default page length
                        ordering: false, // Disable ordering
                    });

                    $("#staff-thesis-search").on("keyup", function () {
                        table.search(this.value).draw(); // Search products based on input
                    });

                    $("#staff-thesis-list").on("click", ".editThesis", function (e) {
                        e.preventDefault(); // Prevent default behavior
                        editThesisRecord(this.dataset.id); // Call function to add product
                    });

                    $("#addThesisBtn").on("click", function (e) {
                        e.preventDefault();
                        addThesisModal();
                    });
                },
            });
        }

        function addThesisModal() {
            $.ajax({
            type: "GET",
            url: "../modals/addThesis-modal.html",
            dataType: "html",
                success: function (view) {
                    $(".modal-container").empty().html(view);
                    $("#addThesisModal").modal("show");

                    $("#form-add-thesis").on("submit", function (e) {
                        e.preventDefault(); // Prevent default form submission
                        addThesis(); // Call function to save product
                      });
                },
                });
        };

        function addThesis(){
            $.ajax({
                type: "POST", // Use POST request
                url: "../student-functions/addThesis.php", // URL for saving product
                data: $("form").serialize(), // Serialize the form data for submission
                dataType: "json", // Expect JSON response
                success: function (response){
                    console.log(response);
                    if (response.status === "error"){
                        if (response.titleErr) {
                            $("#thesisTitle").addClass("is-invalid"); // Mark field as invalid
                            $("#thesisTitle").next(".invalid-feedback").text(response.titleErr).show(); // Show error message
                        }else{
                            $("#thesisTitle").removeClass("is-invalid"); // Remove invalid class if no error
                        }
    
                        if (response.advisorNameErr) {
                            $("#advisorName").addClass("is-invalid"); // Mark field as invalid
                            $("#advisorName").next(".invalid-feedback").text(response.advisorNameErr).show(); // Show error message
                        }else{
                            $("#advisorName").removeClass("is-invalid"); // Remove invalid class if no error
                        }
    
                        if (response.abstractErr) {
                            $("#shortDesc").addClass("is-invalid"); // Mark field as invalid
                            $("#shortDesc").next(".invalid-feedback").text(response.abstractErr).show(); // Show error message
                        }else{
                            $("#shortDesc").removeClass("is-invalid"); // Remove invalid class if no error
                        }

                        if (response.datePublishedErr) {
                            $("#datePublished").addClass("is-invalid"); // Mark field as invalid
                            $("#datePublished").next(".invalid-feedback").text(response.datePublishedErr).show(); // Show error message
                        }else{
                            $("#datePublished").removeClass("is-invalid"); // Remove invalid class if no error
                        }
                    }else if (response.status === "success") {
                        // On success, hide modal and reset form
                        $("#addThesisModal").modal("hide");
                        $("form")[0].reset(); // Reset the form
                        // Optionally, reload products to show new entry
                        thesisList();
                      }
                }
            })
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
                $("#advisorName").val(currThesisData.advisorName);
                $("#shortDesc").val(currThesisData.abstract);
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

            let advisorName = $("#advisorName").val();
            if (!advisorName) {
                hasErrors = true;
                $("#advisorName").addClass("is-invalid");
                $("#advisorName").next(".invalid-feedback").text("Advisor Name is required.").show();
            }

            let abstract = $("#shortDesc").val();
            if (!abstract) {
                hasErrors = true;
                $("#shortDesc").addClass("is-invalid");
                $("#shortDesc").next(".invalid-feedback").text("Abstract is required.").show();
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
                        if (response.advisorNameErr) {
                            $("#advisorName").addClass("is-invalid"); // Mark field as invalid
                            $("#advisorName").next(".invalid-feedback").text(response.advisorNameErr).show(); // Show error message
                        }else{
                            $("#advisorName").removeClass("is-invalid"); // Remove invalid class if no error
                        }
    
                        if (response.abstractErr) {
                            $("#shortDesc").addClass("is-invalid"); // Mark field as invalid
                            $("#shortDesc").next(".invalid-feedback").text(response.abstractErr).show(); // Show error message
                        }else{
                            $("#shortDesc").removeClass("is-invalid"); // Remove invalid class if no error
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
                        dom: "irtp", // Set DataTable options
                        pageLength: 6, // Default page length
                        ordering: false, // Disable ordering
                    });

                    $("#staff-thesis-search").on("keyup", function () {
                        table.search(this.value).draw(); // Search products based on input
                    });

                    $("#addMemberBtn").on("click", function (e) {
                        e.preventDefault();
                        showMemberModal();
                    });

                    $("#staff-thesis-list").on("click", ".editMember", function (e) {
                        e.preventDefault(); // Prevent default behavior
                        showEditModal(this.dataset.id); // Call function to add product
                    });
                },
            });
        }

        function showEditModal(memberID) {
            console.log(memberID);
            $.ajax({
            type: "GET",
            url: "../modals/editMember-modal.html",
            dataType: "html",
                success: function (view) {
                    fetchSpecificMemberData(memberID);
                    $(".modal-container").empty().html(view);
                    $("#editMemberModal").modal("show");
                    $("#editMemberModal").attr("data-id", memberID);

                    $("#form-edit-modal").on("submit", function (e) {
                        e.preventDefault(); // Prevent default form submission
                        editMember(memberID); // Call function to save product
                      });
                },
                });
        };

        function editMember(memberID){
            console.log(memberID);
            $.ajax({
                type: "POST", // Use POST request
                url: `../student-functions/editMember.php?id=${memberID}`, // URL for saving product
                data: $("form").serialize(), // Serialize the form data for submission
                dataType: "json", // Expect JSON response
                success: function (response){
                    if (response.status === "error"){    
                        if (response.lastNameErr) {
                            $("#lastName").addClass("is-invalid"); // Mark field as invalid
                            $("#lastName").next(".invalid-feedback").text(response.lastNameErr).show(); // Show error message
                        }else{
                            $("#lastName").removeClass("is-invalid"); // Remove invalid class if no error
                        }
    
                        if (response.firstNameErr) {
                            $("#firstName").addClass("is-invalid"); // Mark field as invalid
                            $("#firstName").next(".invalid-feedback").text(response.firstNameErr).show(); // Show error message
                        }else{
                            $("#firstName").removeClass("is-invalid"); // Remove invalid class if no error
                        }

                        if (response.middleNameErr) {
                            $("#middleName").addClass("is-invalid"); // Mark field as invalid
                            $("#middleName").next(".invalid-feedback").text(response.middleNameErr).show(); // Show error message
                        }else{
                            $("#middleName").removeClass("is-invalid"); // Remove invalid class if no error
                        }
                    }else if (response.status === "success") {
                        // On success, hide modal and reset form
                        $("#editMemberModal").modal("hide");
                        $("form")[0].reset(); // Reset the form
                        // Optionally, reload products to show new entry
                        memberList();
                      }
                }
            })
        }

        function fetchSpecificMemberData(memberID) {
            $.ajax({
              url: `../student-functions/fetchMemberData.php?id=${memberID}`, // URL for fetching categories
              type: "POST", // Use GET request
              dataType: "json", // Expect JSON response
              success: function (memberData) {
                $("#lastName").val(memberData.lastName);
                $("#firstName").val(memberData.firstName);
                $("#middleName").val(memberData.middleName);
              },
            });
        }

        function showMemberModal() {
            $.ajax({
            type: "GET",
            url: "../modals/addMember-modal.html",
            dataType: "html",
                success: function (view) {
                    $(".modal-container").empty().html(view);
                    $("#addMemberModal").modal("show");

                    $("#form-add-modal").on("submit", function (e) {
                        e.preventDefault(); // Prevent default form submission
                        addMember(); // Call function to save product
                      });
                },
                });
        };

        function addMember(){
            $.ajax({
                type: "POST", // Use POST request
                url: "../student-functions/addMember.php", // URL for saving product
                data: $("form").serialize(), // Serialize the form data for submission
                dataType: "json", // Expect JSON response
                success: function (response){
                    console.log(response);
                    if (response.status === "error"){
                        if (response.studIDErr) {
                            $("#studentID").addClass("is-invalid"); // Mark field as invalid
                            $("#studentID").next(".invalid-feedback").text(response.studIDErr).show(); // Show error message
                        }else{
                            $("#studentID").removeClass("is-invalid"); // Remove invalid class if no error
                        }
    
                        if (response.lastNameErr) {
                            $("#lastName").addClass("is-invalid"); // Mark field as invalid
                            $("#lastName").next(".invalid-feedback").text(response.lastNameErr).show(); // Show error message
                        }else{
                            $("#lastName").removeClass("is-invalid"); // Remove invalid class if no error
                        }
    
                        if (response.firstNameErr) {
                            $("#firstName").addClass("is-invalid"); // Mark field as invalid
                            $("#firstName").next(".invalid-feedback").text(response.firstNameErr).show(); // Show error message
                        }else{
                            $("#firstName").removeClass("is-invalid"); // Remove invalid class if no error
                        }

                        if (response.middleNameErr) {
                            $("#middleName").addClass("is-invalid"); // Mark field as invalid
                            $("#middleName").next(".invalid-feedback").text(response.middleNameErr).show(); // Show error message
                        }else{
                            $("#middleName").removeClass("is-invalid"); // Remove invalid class if no error
                        }
                    }else if (response.status === "success") {
                        // On success, hide modal and reset form
                        $("#addMemberModal").modal("hide");
                        $("form")[0].reset(); // Reset the form
                        // Optionally, reload products to show new entry
                        memberList();
                      }
                }
            })
        }
    
        function trackThesis() {
            $.ajax({
              type: "GET",
              url: "../student-view/view-track-thesis.php",
              dataType: "html",
              success: function (response) {
                $("#dashboard-main-display").html(response);
                    var table = $("#staff-thesis-list").DataTable({
                        dom: "irtp", // Set DataTable options
                        pageLength: 6, // Default page length
                        ordering: false, // Disable ordering
                    });

                    $("#staff-thesis-search").on("keyup", function () {
                        table.search(this.value).draw(); // Search products based on input
                    });
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
                    var table = $("#staff-thesis-list").DataTable({
                        dom: "irtp", // Set DataTable options
                        pageLength: 6, // Default page length
                        ordering: false, // Disable ordering
                    });

                    $("#staff-thesis-search").on("keyup", function () {
                        table.search(this.value).draw(); // Search products based on input
                    });

                    $("#staff-thesis-list").on("click", ".reqData", function (e) {
                        e.preventDefault(); // Prevent default behavior
                        fetchDataRecord(this.dataset.id); // Call function to add product
                    });
                },
            });
        }

        function fetchDataRecord(reqData) {
            $.ajax({
                type: "GET", // Use GET request
                url: "../student-view/view-request-thesis-function.php", // URL to get product data
                data: { id: reqData }, // Pass the ID as part of the request
                dataType: "html", // Expect HTML response
                success: function (view) {
                    // Assuming 'view' contains the new content you want to display
                    $(".modal-container").empty().html(view); // Load the modal view
                    $("#reqDataModal").modal("show"); // Show the modal
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