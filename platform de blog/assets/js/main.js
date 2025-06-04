/**
 * Main JavaScript file for the Blog Platform
 */

document.addEventListener('DOMContentLoaded', function() {
    // Enable Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Enable Bootstrap popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Handle form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Comment form handling
    const commentForm = document.getElementById('comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(commentForm);
            
            // Send AJAX request
            fetch('includes/add_comment.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add comment to the page
                    const commentsContainer = document.getElementById('comments-container');
                    const newComment = document.createElement('div');
                    newComment.className = 'comment';
                    newComment.innerHTML = `
                        <div class="comment-author">${data.comment.username}</div>
                        <div class="comment-date">${data.comment.created_at}</div>
                        <div class="comment-content">${data.comment.content}</div>
                    `;
                    commentsContainer.appendChild(newComment);
                    
                    // Reset form
                    commentForm.reset();
                    
                    // Show success message
                    const alertContainer = document.getElementById('alert-container');
                    alertContainer.innerHTML = '<div class="alert alert-success">Commentaire ajouté avec succès!</div>';
                    
                    // Hide alert after 3 seconds
                    setTimeout(() => {
                        alertContainer.innerHTML = '';
                    }, 3000);
                } else {
                    // Show error message
                    const alertContainer = document.getElementById('alert-container');
                    alertContainer.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    }
    
    // Like button functionality
    const likeButtons = document.querySelectorAll('.like-button');
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.getAttribute('data-post-id');
            
            fetch('includes/like_post.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `post_id=${postId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update like count
                    const likeCount = this.querySelector('.like-count');
                    likeCount.textContent = data.likes;
                    
                    // Toggle active class
                    this.classList.toggle('active');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
}); 