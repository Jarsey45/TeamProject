class Toast {
	constructor() {
			if (Toast.instance) {
					return Toast.instance;
			}
			Toast.instance = this;
			this.createToastContainer();
	}

	createToastContainer() {
			const container = document.createElement('div');
			container.id = 'toast-container';
			container.style.cssText = `
					position: fixed;
					bottom: 20px;
					right: 20px;
					z-index: 1050;
			`;
			document.body.appendChild(container);
	}

	show(message, type = 'info', duration = 10000) {
			const toast = document.createElement('div');
			toast.className = `toast toast-${type}`;
			toast.style.cssText = `
					min-width: 200px;
					margin-bottom: 10px;
					padding: 15px;
					border-radius: 4px;
					opacity: 0;
					transition: opacity 0.3s ease-in-out;
					animation: slideIn 0.3s ease-in-out;
			`;

			toast.innerHTML = message;
			document.getElementById('toast-container').appendChild(toast);

			setTimeout(() => toast.style.opacity = '1', 10);
			setTimeout(() => {
					toast.style.opacity = '0';
					setTimeout(() => toast.remove(), 300);
			}, duration);
	}
}

// Create a global instance
window.toastManager = new Toast();
