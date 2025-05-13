export function setCookie(nome_cookie, valore_cookie, secondi) {
    const data = new Date();
    data.setTime(data.getTime() + secondi);
    let scadenza = "expires="+data.toUTCString();
    document.cookie = nome_cookie + "=" + valore_cookie + ";" + scadenza + ";path=/";
}

export function getCookie(nome) {
    let name = nome + "=";
    let char = document.cookie.split(';');
    for(let i = 0; i < char.length; i++) {
        let c = char[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return "";
}

export function checkCookie() {
    let login_cookie = getCookie("login");
    if(login_cookie != ''){
        if(login_cookie == "SUCCESSFULL"){
            alert("Login effettuato con successo");
            window.location.href = "dashboard.php";
        }
        else alert("Credenziali non corrette");
    }
}