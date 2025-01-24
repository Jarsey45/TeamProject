document.addEventListener('DOMContentLoaded', () => {
	const toggleButtons = document.querySelectorAll('.toggle-comment');

	toggleButtons.forEach(button => {
			button.addEventListener('click', () => {
					const postId = button.getAttribute('data-post-id');
					const commentInputContainer = document.getElementById(`comment-section-${postId}`);

					if (commentInputContainer) {
							const isHidden = commentInputContainer.style.display === 'none';
							commentInputContainer.style.display = isHidden ? 'block' : 'none';
					}
			});
	});
});
