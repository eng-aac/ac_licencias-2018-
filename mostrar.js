function habilitar(value){
    if(value=="Otros" || value==true){
        document.getElementById("comentarios").hidden=false;
        document.getElementById("t_comentarios").hidden=false;
    }else if (value=="Razones Particulares" || value=="Enfermedad" || value=="ART" || value=="Mesa de Examen" || value=="Cursos" || value=="Paternidad" || value=="Embarazo" || value==false){
        document.getElementById("comentarios").hidden=true;
        document.getElementById("t_comentarios").hidden=true;
    }
}