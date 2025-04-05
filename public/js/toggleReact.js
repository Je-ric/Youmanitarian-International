function toggleReact(contentId, csrfToken) {
    let heartButton = document.getElementById(`heartButton-${contentId}`);
    let heartIcon = document.getElementById(`heartIcon-${contentId}`);
    let heartCount = document.getElementById(`heartCount-${contentId}`);
    
    let reacted = heartButton.getAttribute("data-reacted") === "true";
    let currentCount = parseInt(heartCount.textContent);

    // Optimistic UI update
    if (reacted) {
        heartIcon.classList.replace("bxs-heart", "bx-heart");
        heartIcon.classList.replace("text-red-600", "text-gray-400");
        heartCount.textContent = currentCount - 1;
        heartButton.setAttribute("data-reacted", "false");
    } else {
        heartIcon.classList.replace("bx-heart", "bxs-heart");
        heartIcon.classList.replace("text-gray-400", "text-red-600");
        heartCount.textContent = currentCount + 1;
        heartButton.setAttribute("data-reacted", "true");
    }

    fetch(`/react/${contentId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "application/json"
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.status !== "success") {
            // Rollback UI changes if request fails
            heartIcon.classList.toggle("bxs-heart", !reacted);
            heartIcon.classList.toggle("bx-heart", reacted);
            heartIcon.classList.toggle("text-red-600", !reacted);
            heartIcon.classList.toggle("text-gray-400", reacted);
            heartCount.textContent = currentCount;
            heartButton.setAttribute("data-reacted", reacted.toString());

            alert(data.message || "Something went wrong!");
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
}


// function toggleReact(contentId) {
//     let heartButton = document.getElementById(`heartButton-${contentId}`);
//     let heartIcon = document.getElementById(`heartIcon-${contentId}`);
//     let heartCount = document.getElementById(`heartCount-${contentId}`);
    
//     let reacted = heartButton.getAttribute("data-reacted") === "true";
//     let currentCount = parseInt(heartCount.textContent);

//     if (reacted) {
//         heartIcon.classList.replace("bxs-heart", "bx-heart");
//         heartIcon.classList.replace("text-red-600", "text-gray-400");
//         heartCount.textContent = currentCount - 1;
//         heartButton.setAttribute("data-reacted", "false");
//     } else {
//         heartIcon.classList.replace("bx-heart", "bxs-heart");
//         heartIcon.classList.replace("text-gray-400", "text-red-600");
//         heartCount.textContent = currentCount + 1;
//         heartButton.setAttribute("data-reacted", "true");
//     }

//     fetch(`/react/${contentId}`, {
//         method: "POST",
//         headers: {
//             "X-CSRF-TOKEN": "{{ csrf_token() }}",
//             "Content-Type": "application/json"
//         },
//     })
//     .then(response => response.json())
//     .then(data => {
//         if (data.status !== "success") {
//             if (reacted) {
//                 heartIcon.classList.replace("bx-heart", "bxs-heart");
//                 heartIcon.classList.replace("text-gray-400", "text-red-600");
//                 heartCount.textContent = currentCount; // Reset count
//                 heartButton.setAttribute("data-reacted", "true");
//             } else {
//                 heartIcon.classList.replace("bxs-heart", "bx-heart");
//                 heartIcon.classList.replace("text-red-600", "text-gray-400");
//                 heartCount.textContent = currentCount; // Reset count
//                 heartButton.setAttribute("data-reacted", "false");
//             }
//             alert(data.message || "Something went wrong!");
//         }
//     }).catch(error => {
//         console.error("Error:", error);
//     });
// }