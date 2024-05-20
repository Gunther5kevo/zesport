// JavaScript for displaying user comments and handling form submission
document.addEventListener('DOMContentLoaded', function() {
    const commentsContainer = document.getElementById('commentsContainer');
    const commentForm = document.getElementById('commentForm');

    // Function to fetch and display user comments
    function fetchUserComments() {
        fetch('fetch_user_comments.php') // Replace 'fetch_user_comments.php' with your server-side script
            .then(response => response.json())
            .then(data => {
                // Update the HTML to display user comments
                commentsContainer.innerHTML = ''; // Clear previous content
                data.forEach(comment => {
                    const commentElement = document.createElement('div');
                    commentElement.innerHTML = `
                        <strong>${comment.author}</strong> (${comment.date})<br>
                        ${comment.content}<br><br>
                    `;
                    commentsContainer.appendChild(commentElement);
                });
            })
            .catch(error => console.error('Error fetching user comments:', error));
    }

    // Fetch and display user comments initially
    fetchUserComments();

    // Handle comment form submission
    commentForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(commentForm);
        const formDataObject = {};
        formData.forEach((value, key) => {
            formDataObject[key] = value;
        });

        
        fetch('add_comment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(formDataObject),
        })
        .then(response => response.json())
        .then(data => {
            
            fetchUserComments();
            commentForm.reset(); // Clear the form
        })
        .catch(error => console.error('Error adding comment:', error));
    });
});
