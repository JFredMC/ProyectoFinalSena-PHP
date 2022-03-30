<?php
	
	require_once "mainModel.php";

	class eventoModelo extends mainModel{

		/*--------- Modelo agregar evento ---------*/
		protected static function agregar_evento_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO tblevento(EveInstructor,EveProgramaDeFormacion,EveFicha,EveCompetencia,EveResultado,EveFechaInicio,EveFechaFin,EveHoraInicio,EveHoraFin,EveDia,EveTotalHoras) VALUES (:Instructor,:ProgramaFormacion,:Ficha,:Competencia,:Resultado,:FechaInicio,:FechaFin,:HoraInicio,:HoraFin,:Dia,:Hora)");

			
			$sql->bindParam(":Instructor",$datos['Instructor']);
			$sql->bindParam(":ProgramaFormacion",$datos['ProgramaFormacion']);
			$sql->bindParam(":Ficha",$datos['Ficha']);
			$sql->bindParam(":Competencia",$datos['Competencia']);
			$sql->bindParam(":Resultado",$datos['Resultado']);
			$sql->bindParam(":FechaInicio",$datos['FechaInicio']);
			$sql->bindParam(":FechaFin",$datos['FechaFin']);
			$sql->bindParam(":HoraInicio",$datos['HoraInicio']);
			$sql->bindParam(":HoraFin",$datos['HoraFin']);
			$sql->bindParam(":Dia",$datos['Dia']);
			$sql->bindParam(":Hora",$datos['Hora']);
			$sql->execute();

			return $sql;
		}

		/*--------- Modelo eliminevento ---------*/
		protected static function eliminar_evento_modelo($id){
			$sql=mainModel::conectar()->prepare("DELETE FROM tblevento WHERE EveCodigo=:Codigo");

			$sql->bindParam(":Codigo", $id);
			$sql->execute();

			return $sql;
		}

		/* MODELO DATOS EVENTOS */
		protected static function datos_evento_modelo($tipo,$id){
			if($tipo=="Unico"){
				$sql=mainModel::conectar()->prepare("SELECT * FROM tblevento WHERE EveCodigo=:ID");
				$sql->bindParam(":ID",$id);
			}elseif($tipo=="Conteo"){
				$sql=mainModel::conectar()->prepare("SELECT EveCodigo FROM tblevento WHERE EveCodigo !='0'");

			}
			$sql->execute();
			return $sql;
		}
		
		/* MODELO ACTUALIZAR EVENTO */
		protected static function actualizar_evento_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE tblevento SET EveInstructor=:Instructor, EveFicha=:Ficha EveDia=:Dia,EveResultado=:Resultado, EveFechaInicio=:FechaInicio, EveFechaFin=:FechaFin WHERE EveCodigo=:ID ");

			$sql->bindParam(":Instructor", $datos['Instructor']);
			$sql->bindParam(":Ficha", $datos['Ficha']);
			$sql->bindParam(":Dia", $datos['Dia']);
			$sql->bindParam(":Resultado", $datos['Resultado']);
			$sql->bindParam(":FechaInicio", $datos['FechaInicio']);
			$sql->bindParam(":FechaFin",$datos['FechaFin']);
			$sql->bindParam(":ID", $datos['ID']);

			$sql->execute();
			return $sql;


		}

		
	}