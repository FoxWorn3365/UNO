function pullEvent(id, player) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/turn?partita=' + id));
  if (res.player == player) {  
    return true;
  } else {
    return false;
  }
}

function getDt() {
  return http_request('https://api.fcosma.it/date');
}

function addLog(app, type, message) {
  document.getElementById('log_bucket').innerHTML = document.getElementById('log_bucket').innerHTML + "<br>[" + getDt() + "]-[" + app + "][#" + type + "] " + message;
}

function checkGame(id) {
  addLog('UnoGame', 'INFO', 'Controllando se il gioco richiesto esiste...');
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/g?id=' + id +'&intent=check'));
  addLog('UnoGame', 'INFO', 'Ricevuto una risposta, status: ' + res.status);
  if (res.status != 200) {
    return false;
  }
}

function isPlayer(id, playerid) {
  addLog('UnoGame', 'INFO', 'Verificando se il player è in game...');
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/g?intent=player&id=' + id +'&playerid=' + playerid));
  addLog('UnoGame', 'INFO', 'Ricevuto una risposta valida, status: ' + res.status);
  if (res.status != 200) {
    return false;
  } else {
    return true;
  }
}

function getTurno(id, playerid) {
  addLog('UnoGame', 'INFO', 'Richiedendo il turno per il check normale...');
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/turno?id=' + id));
  addLog('UnoGame', 'INFO', 'Ricevuto una risposta valida, status: ' + res.status);
  if (res.status == 200) {
    if (res.turno == playerid) {
      return true;
      alert("E' il tuo turno");
    } else {
      return false;
      alert("NO UTNRO");
    }
  } else {
    addLog('UnoGame', 'WARNING', 'La richiesta non è stata accettata dal server principale!');
    alert("ERRORE, I SERVER NON HANNO ACCETTATO LA RICHIESTA!");
  }
}

function getPlayerid() {
  addLog('UnoGame', 'ACT', 'Recuperato il PlayerID');
  return document.getElementById('temp_1').innerHTML;
}

function getCentro(id) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/centro?id=' + id));
  addLog('UnoGame', 'INFO', 'Recupero della carta centrale avvenuto con successo!');
  if (res.status == 200) {
    return res.card;
  }
}

function setCentro(id) {
  addLog('UnoGame', 'INFO-LOCALE', 'Carta recuperata dal locale');
  document.getElementById('carta_mazzo').src = "assets/mazzo/" + getCentro(id) + ".jpg";
}

function poniCarta(id, playerid, card) {
  addLog('UnoGame', 'INFO', 'Richiesta di immissione di una carta in corso...');
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/mettiUnaCarta?id=' + id + '&card=' + card + '&playerid=' + playerid));
  addLog('UnoGame', 'INFO', 'Richiesta inviata con successo e ricevuta una risposta!');
  if (res.status != 200) {
    addLog('UnoGame', 'WARNING', 'La richiesta è stata rifiutata dai server centrali');
    alert("RICHIESTA RIFIUTATA DAL SERVER api.fcosma.it/uno/");
  }
}

function refreshMazzo(id, playerid) {
   addLog('UnoGame', 'INFO', 'Recupero inventario del giocatore');
   var mazzo = getMazzo(code, playerid);
   for (let i = 1; i < 16; i++) {
     document.getElementById('mazzo_' + i).style.display = "none";
   }

   for (let a = 0; a < mazzo.length; a++) {
     if (mazzo[a] != "") {
       document.getElementById('mazzo_' + (a+1)).style.display = "inline";
       document.getElementById('mazzo_' + (a+1)).name = mazzo[a];
       document.getElementById('mazzo_' + (a+1)).src = 'assets/mazzo/' + mazzo[a] + '.jpg';
     } else {
       document.getElementById('mazzo_' + (a+1)).style.display = "none";
     }
   }
   addLog('UnoGame', 'INFO', 'Inventario sistemato con successo!');
}

function joinStat(id, playerid) {
  addLog('UnoGame', 'INFO', 'Richiesta di ingresso in-game in corso!');
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/join?id=' + id + '&playerid=' + playerid));
  addLog('UnoGame', 'INFO', 'Risposta ricevuta con successo!');
  if (res.status == 200) {
    return true;
  } else {
    return false;
  }
}

function pickACard(id, playerid) {
  addLog('UnoGame', 'INFO', 'Inoltrando al server la richiesta per pescare una carta...');
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/pesca?id=' + id + '&playerid=' + playerid));
  addLog('UnoGame', 'INFO', 'Ricevuto una risposta valida!');
  if (res.status == 200) {
    return true;
  } else {
    return false;
  }
}

function isStart(id) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/st?id=' + id));
  addLog('UnoGame', 'INFO', 'Richiesta al server per sapere se la partita è iniziata');
  if (res.status == 200) {
    return true;
  } else {
    return false;
  }
}

function getPlayers(id) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/getPlayersList?id=' + id));
  addLog('UnoGame', 'INFO', 'Recupero giocatori avvenuto con successo!');
  if (res.status == 200) {
    return res.members;
  } else {
    return false;
  }
}

function getMazzo(id, playerid) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/mazzo?intent=get&playerid=' + playerid + '&id=' + id));
  addLog('UnoGame', 'INFO', 'Mazzo recuperato con successo!');
  return res.mazzo;
}

function getAvversarioCardList(id, playerid) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/altroMazzo?id=' + id + '&playerid=' + playerid));
  addLog('UnoGame', 'INFO', 'Numero di carte nemiche recuperato con successo!');
  return res.value;
}

function getCenterCard(id) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/centro?id=' + id));
  addLog('UnoGame', 'INFO', 'Recuperata dai server la carta centrale');
  return res.mazzo;
}

function gamePesca(id, playerid) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/pick?id=' + id + '&playerid=' + playerid));
  addLog('UnoGame', 'INFO', 'Pescato una carta');
  return getMazzo(id, playerid);
}

function isInGame(id, playerid) {
  var ext = getPlayers(id);
  for (let a = 0; a < 10; a++) {
    if (ext[a] == playerid) {
      return true;
    }
  }

  return false;
}

function getURL() {
  var text = window.location.href;
  const array = text.split("?");
  if (array[1] != null) {
    const spl = array[1].split("=");
    if (spl[0] == "partita") {
      return spl[1];
    } else {
      return false;
    }
  } else {
    return false;
  }
}

function goTurn(id, playerid) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/cambiaTurno?id=' + id + '&playerid=' + playerid));
  addLog('UnoGame', 'INFO', 'Cambio di turno');
  if (res.status == 200) {
    document.getElementById('todo_1').style.color = "black";
  }
}

function reboot(id) {
  http_request('https://api.fcosma.it/uno/reset?id=' + id);
  window.location.href = 'https://fcosma.it/uno/?thanks';
}

function getWinner(id) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/isFinished?id=' + id));
  return res.winner;
}

function isFinished(id) {
  var res = JSON.parse(http_request('https://api.fcosma.it/uno/isFinished?id=' + id));
  if (res.status == 200) {
    return true;
  } else {
    return false;
  }
}

function vincitore(id, player) {  
  document.getElementById('temp_1').innerHTML = "";
  document.getElementById('game').style.display = "none";
  document.getElementById('winner').style.display = "block";
  document.getElementById('winner_label').innerHTML = "Il vincitore è " + player;
  setTimeout(window.location.href = 'https://fcosma.it/uno/?thanks', 5000);
}
