document.addEventListener("DOMContentLoaded", function () {
	if (!window.location.hash) {
		let defaultAnchor = document.getElementById("start")
		if (defaultAnchor) defaultAnchor.scrollIntoView()
	}
})
