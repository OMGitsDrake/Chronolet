let numSessione = 1;
function avviaSessione(){
    let circuito = document.getElementById("circuito").value;
    let moto = document.getElementById("moto").value;
    let errMsg = document.getElementById("noData");

    if(circuito == "Seleziona Circuito" || moto == "Seleziona Moto"){
        errMsg.hidden = false;
        return;
    }

    errMsg.hidden = true;

    let turni = Math.floor(Math.random()*6 + 1);

    let sessione = new Array(turni);
    let best = Infinity;
    for(let i = 0; i < sessione.length; i++){
        let giri = Math.floor(Math.random()*10 + 1);
        sessione[i] = new Array(giri);
        
        for (let j = 0; j < sessione[i].length; j++){
            sessione[i][j] = generateTime(circuito);
            
            if(sessione[i][j] == -1){
                alert("Si è verificato un imprevisto!");
                return;
            }
            best = (sessione[i][j][0] < best) ? sessione[i][j][0] : best;
        }
    }

    let table = document.getElementById("res");
    let heads = new Array(
        "Tempo",
        "T 1",
        "T 2",
        "T 3",
        "T 4"
        );
    table.appendChild(document.createElement("tr"));
    table.lastChild.appendChild(document.createTextNode("Sessione: " + numSessione++ + " Moto: " + moto));
    table.appendChild(document.createElement("tr"));
    for(let i = 0; i < heads.length; i++){
        table.lastChild.appendChild(document.createElement("th"));
        table.lastChild.lastChild.appendChild(document.createTextNode(heads[i]));
    }

    for(let i = 0; i < sessione.length; i++){
        table.appendChild(document.createElement("tr"));
        table.lastChild.appendChild(document.createTextNode("Turno: " + (i+1)));
        for(let j = 0; j < sessione[i].length; j++){
            table.appendChild(document.createElement("tr"));
            for(let k = 0; k < sessione[i][j].length; k++){
                table.lastChild.appendChild(document.createElement("td"));
                table.lastChild.lastChild.appendChild(document.createTextNode(parseMillis(sessione[i][j][k])));
                if(sessione[i][j][0] == best)
                    table.lastChild.firstChild.setAttribute("id", "best");
            }
        }
    }
    
    const save = document.getElementById("save");
    if(save.hidden)
        save.hidden = false;
}

function generateTime(c){
    let time = new Array(5);
    // TODO: Generare settori prima
    //      sommarli poi nel tempo totale
    switch (c) {
        case "Autodromo dell'Umbria":
        //Math.floor(Math.random()*(105000 - 68000) + 68000)    
            time[0] = 0;
            time[1] = Math.floor(Math.floor(Math.random()*(105000 - 68000) + 68000)/4);
            time[2] = Math.floor(Math.floor(Math.random()*(105000 - 68000) + 68000)/8);
            time[3] = Math.floor(Math.floor(Math.random()*(105000 - 68000) + 68000)/4);
            time[4] = Math.floor(Math.floor(Math.random()*(105000 - 68000) + 68000)*(3/8));
            for (let i = 1; i <= 4; i++)
                time[0] += time[i];
            
            break;

        case "Autodromo Vallelunga":
            time[0] = Math.floor(Math.random()*(130000 - 95000) + 95000);
            time[1] = time[0]/3;
            time[2] = time[0]/4;
            time[3] = time[0]/4;
            time[4] = time[0]/6;
            break;

        case "Cremona Circuit":
            time[0] = Math.floor(Math.random()*(130000 - 95000) + 95000);
            time[1] = time[0]/5;
            time[2] = time[0]/4;
            time[3] = time[0]/4;
            time[4] = time[0]*(3/10);
            break;

        case "Mugello Circuit":
            time[0] = Math.floor(Math.random()*(145000 - 105000) + 105000);
            time[1] = time[0]/4;
            time[2] = time[0]/3;
            time[3] = time[0]/8;
            time[4] = time[0]*(7/24);
            break;

        case "Misano World Circuit":
            time[0] = Math.floor(Math.random()*(120000 - 92000) + 92000);
            time[1] = time[0]/4;
            time[2] = time[0]*(2/5);
            time[3] = time[0]*(1/5);
            time[4] = time[0]*(3/20);
            break;

        default:
            return -1;
    }
    return time;
}

function parseMillis(millis){
    min = 0;
    sec = 0;

    sec = Math.floor(millis / 1000);
    dec = Math.ceil((millis / 1000 - sec)*1000);
    
    if(sec >= 60){
        min = Math.floor(sec / 60);
        sec %= 60;
    }

    return min + ':' + sec + '.' + dec;
}