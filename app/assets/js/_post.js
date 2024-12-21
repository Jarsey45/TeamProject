class PostLoader {
	constructor() {
		this.offset = 5;
		this.loading = false;
		this.hasMore = true;
		this.currentRequest = null;
		this.feedSection = document.querySelector('.feed');
		this.loadingPlaceholder = document.querySelector('.loading-placeholder');
		this.scrollPosition = 0;

		// Debounced handleIntersection
		this.debouncedHandle = this.debounce(this.handleIntersection.bind(this), 250);

		this.observer = new IntersectionObserver(
			entries => this.debouncedHandle(entries),
			{ threshold: 1, rootMargin: '100px' }
		);

		if (this.loadingPlaceholder) {
			this.observer.observe(this.loadingPlaceholder);
		}

		window.addEventListener('scroll', () => {
			this.scrollPosition = window.scrollY;
		});
	}

	async handleIntersection(entries) {
		const entry = entries[0];
		if (entry.isIntersecting && !this.loading && this.hasMore) {
			if (this.currentRequest) {
				await this.currentRequest;
			}
			this.currentRequest = this.loadMorePosts();
			await this.currentRequest;
		}
	}

	//TODO: fix this xd, it's not working correctly
	async loadMorePosts() {
		if (this.loading) return;

		try {
			this.loading = true;
			this.observer.unobserve(this.loadingPlaceholder);
			this.loadingPlaceholder.style.display = 'flex';

			const response = await fetch(`/api/posts?offset=${this.offset}&limit=5`);
			const json = await response.json();
			// console.log(`/api/posts?offset=${this.offset}&limit=5`);
			if (json.length === 0) {
				this.hasMore = false;
				this.loadingPlaceholder.style.display = 'none';
				this.observer.disconnect();
				return;
			}

			this.offset += 5;

			const heightBefore = document.documentElement.scrollHeight;

			for (const el of json) {
				this.loadingPlaceholder.insertAdjacentHTML('beforebegin', el.content);
			}

			// Restore scroll position
			const heightAfter = document.documentElement.scrollHeight;
			const heightDiff = heightAfter - heightBefore;
			if (this.scrollPosition > 0) {
				window.scrollTo({
					top: this.scrollPosition + heightDiff,
					behavior: 'instant'
				});
			}

		} catch (error) {
			console.error('Error loading posts:', error);
			this.hasMore = false;
		} finally {
			this.loading = false;
			this.currentRequest = null;
			this.loadingPlaceholder.style.display = this.hasMore ? 'flex' : 'none';

			if (this.hasMore) {
				this.observer.observe(this.loadingPlaceholder);
			}
		}
	}

	debounce(func, wait) {
		let timeout;
		return function executedFunction(...args) {
			const later = () => {
				clearTimeout(timeout);
				func(...args);
			};
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
		};
	}
}

window.postLoader = new PostLoader();
