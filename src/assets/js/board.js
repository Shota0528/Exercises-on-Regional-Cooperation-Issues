class Poster {
    constructor(id, x, y, h, w) {
        this.id = id;
        this.x = x;
        this.y = y;
        this.h = h;
        this.w = w;
    }
    CheckClick(clickPos, scale) {
        return (
            (this.x * scale <= clickPos.x && clickPos.x <= (this.x + this.w) * scale) &&
            (this.y * scale <= clickPos.y && clickPos.y <= (this.y + this.h) * scale)
        )
    }
    CheckCover(x, y, h, w) {
        return (
            (this.x + this.w < x) ||
            (this.y + this.h < y) ||
            (x + w < this.x) ||
            (y + h < this.y)
        )
    }

}

window.onload = () => {
    const canvasBox = document.getElementById('board-container');
    const canvas = document.getElementById("board-canvas");
    const context = canvas.getContext("2d");

    // Init
    let scale = 1;
    let moveFlag = false;
    let flag = false;
    canvasBox.scrollTop = 0;
    canvasBox.scrollLeft = 0;
    const oldPos = {
        x: 0,
        y: 0
    }

    const posters = [];
    Array.prototype.forEach.call(document.getElementsByClassName('poster'), poster => {
        let flag = true
        let c = 0
        let x = 0
        let y = 0
        let w = poster.naturalWidth
        let h = poster.naturalHeight
        while(flag && c < 7) {
            x = Math.random() * 5000
            y = Math.random() * 5000
            zoom = (70 + Math.floor(Math.random() * 30)) / 100
            w *= zoom;
            h *= zoom;


            x = (x + w > 5000) ? 5000 - x + w : x;
            y = (y + h > 5000) ? 5000 - y + h : y;
            
            let overFlag = true
            Array.prototype.forEach.call(posters, poster => {
                if (overFlag && !poster.CheckCover(x, y, h, w)) {
                    overFlag = false
                }
            })
            flag = !overFlag
            c++;
        }
        context.drawImage(poster, x, y, w, h)
        posters.push(new Poster(poster.name, x, y, h, w))
        
        
        
    })
    console.log(posters)

    canvasBox.addEventListener('mousedown', (e) => {
        moveFlag = false;
        // console.log("down")
        oldPos.x = e.clientX;
        oldPos.y = e.clientY;
        canvasBox.style.cursor = "grabbing";
        flag = true
    })
    canvasBox.addEventListener('mouseup', (e) => {
        // console.log("up")
        flag = false
        canvasBox.style.cursor = "grab";

        if (!moveFlag) {
            const rect = canvas.getBoundingClientRect();
            const point = {
                x: (e.clientX - rect.left) * 2,
                y: (e.clientY - rect.top) * 2,
            }
            // console.log("click: " + Object.values(point))
            // console.log("==click-Debug==");
            Array.prototype.forEach.call(posters, poster => {
                // console.log(poster)
                if (poster.CheckClick(point, scale)) {
                    window.location.assign("./poster.php?id=" + poster.id);
                }
            })
            console.log("==============");
        }
    })

    canvasBox.addEventListener('mousemove', (e) => {
        moveFlag = true;
        if (flag) {
            diffPos = {
                x: oldPos.x - e.clientX,
                y: oldPos.y - e.clientY,
            }
            oldPos.x = e.clientX;
            oldPos.y = e.clientY;
            // console.log("diff:" + Object.values(diffPos))
            canvasBox.scrollTop += diffPos.y;
            canvasBox.scrollLeft += diffPos.x;
        }
    })
    canvasBox.addEventListener("wheel", (e) => {
        e.preventDefault();
        scale += e.deltaY * -0.0005;
        scale = Math.min(Math.max(.5, scale), 4);
        canvas.style.transform = `scale(${scale})`;
    })
}
