<?php
	
	require_once "mainModel.php";

	class resultadoModelo extends mainModel{

		/*--------- Modelo agregar RESULTADO ---------*/
		protected static function agregar_resultado_modelo($datos){
			$sql=mainModel::conectar()->prepare("INSERT INTO tblresultadodeaprendizaje(ResCodigo,FkRel_Resultado_Competencia,ResNombre,ResHoras) VALUES (:CodigoResul,:RelResultadoCompetencia,:Nombre,:Hora)");
			$sql->bindParam(":CodigoResul",$datos['CodigoResul']);
			$sql->bindParam(":RelResultadoCompetencia",$datos['RelResultadoCompetencia']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Hora",$datos['Hora']);
			$sql->execute();

			return $sql;
		}

		/*--------- Modelo eliminar RESULTADO ---------*/
		protected static function eliminar_resultado_modelo($id){
			$sql=mainModel::conectar()->prepare("DELETE FROM tblresultadodeaprendizaje WHERE ResId=:ID");

			$sql->bindParam(":ID", $id);
			$sql->execute();

			return $sql;
		}

		/* MODELO DATOS ERESULTADO */
		protected static function datos_resultado_modelo($tipo,$id){
			if($tipo=="Unico"){
				$sql=mainModel::conectar()->prepare("SELECT * FROM tblresultadodeaprendizaje WHERE ResId=:ID");
				$sql->bindParam(":ID",$id);
			}elseif($tipo=="Conteo"){
				$sql=mainModel::conectar()->prepare("SELECT ResId FROM tblresultadodeaprendizaje WHERE ResId !='0'");

			}
			$sql->execute();
			return $sql;
		}
		
		/* MODELO ACTUALIZAR RESULTADO */
		protected static function actualizar_resultado_modelo($datos){
			$sql=mainModel::conectar()->prepare("UPDATE tblresultadodeaprendizaje SET ResCodigo=:CodigoResul,ResNombre=:Nombre,ResHoras=:Hora WHERE ResId=:ID ");

			$sql->bindParam(":CodigoResul",$datos['CodigoResul']);
			$sql->bindParam(":Nombre",$datos['Nombre']);
			$sql->bindParam(":Hora",$datos['Hora']);
			$sql->bindParam(":ID",$datos['ID']);
			$sql->execute();

			return $sql;			
		}

		
	}