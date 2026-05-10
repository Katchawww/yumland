const sortSelect = document.getElementById("tri");

sortSelect.addEventListener("change", function() {

    const menus =
        Array.from(document.querySelectorAll(".menu"));


    if(this.value === "prix+") {

        menus.sort((a, b) =>
            a.dataset.price - b.dataset.price
        );
    }

    if(this.value === "prix-") {

        menus.sort((a, b) =>
            b.dataset.price - a.dataset.price
        );
    }

    if(this.value === "tri-nom") {

        menus.sort((a, b) =>
            a.dataset.name.localeCompare(b.dataset.name)
        );
    }
    const container1 =
        document.querySelector(".menus");


    menus.forEach(card => {

        container1.appendChild(card);
    });




    const entrees =
        Array.from(document.querySelectorAll(".entree"));


    if(this.value === "prix+") {

        entrees.sort((a, b) =>
            a.dataset.price - b.dataset.price
        );
    }

    if(this.value === "prix-") {

        entrees.sort((a, b) =>
            b.dataset.price - a.dataset.price
        );
    }

    if(this.value === "tri-nom") {

        entrees.sort((a, b) =>
            a.dataset.name.localeCompare(b.dataset.name)
        );
    }
    const container2 =
        document.querySelector(".entrees");


    entrees.forEach(card => {

        container2.appendChild(card);
    });



    const plats =
    Array.from(document.querySelectorAll(".plat"));

    if(this.value === "prix+") {

        plats.sort((a, b) =>
            a.dataset.price - b.dataset.price
        );
    }

    if(this.value === "prix-") {

        plats.sort((a, b) =>
            b.dataset.price - a.dataset.price
        );
    }

    if(this.value === "tri-nom") {

        plats.sort((a, b) =>
            a.dataset.name.localeCompare(b.dataset.name)
        );
    }
    const container3 =
        document.querySelector(".plats");


    plats.forEach(card => {

        container3.appendChild(card);
    });





    const desserts =
    Array.from(document.querySelectorAll(".dessert"));

    if(this.value === "prix+") {

        desserts.sort((a, b) =>
            a.dataset.price - b.dataset.price
        );
    }

    if(this.value === "prix-") {

        desserts.sort((a, b) =>
            b.dataset.price - a.dataset.price
        );
    }

    if(this.value === "tri-nom") {

        desserts.sort((a, b) =>
            a.dataset.name.localeCompare(b.dataset.name)
        );
    }
    const container4 =
        document.querySelector(".desserts");


    desserts.forEach(card => {

        container4.appendChild(card);
    });



    const boissons =
    Array.from(document.querySelectorAll(".boisson"));

    if(this.value === "prix+") {

        boissons.sort((a, b) =>
            a.dataset.price - b.dataset.price
        );
    }

    if(this.value === "prix-") {

        boissons.sort((a, b) =>
            b.dataset.price - a.dataset.price
        );
    }

    if(this.value === "tri-nom") {

        boissons.sort((a, b) =>
            a.dataset.name.localeCompare(b.dataset.name)
        );
    }
    const container5 =
        document.querySelector(".boissons");


    boissons.forEach(card => {

        container5.appendChild(card);
    });
});