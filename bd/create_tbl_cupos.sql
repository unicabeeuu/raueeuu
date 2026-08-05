-- ============================================================================
-- tbl_cupos
--
-- ATENCIÓN: esta estructura fue RECONSTRUIDA a partir de las columnas que
-- referencian los queries de la aplicación, NO exportada de producción:
--   - registro/estudianteunicab/cupo.php
--   - registro/adminunicab/cupos_getdat.php
--   - registro/adminunicab/cupos_getdat1.php
--
-- La tabla no existe en bd/db_admin_unieeuu.sql ni en la base local, por lo que
-- el dump de desarrollo está incompleto. Los TIPOS de las columnas que no
-- participan en un JOIN son una inferencia razonable, no un dato verificado.
-- Reconciliar contra producción antes de dar por buena esta definición:
--   SHOW CREATE TABLE tbl_cupos;
--
-- Los tipos de las columnas que sí participan en JOIN se tomaron del esquema
-- real para que las uniones no fallen ni degraden el índice:
--   n_documento         -> tbl_estudiantes.n_documento  varchar(15)
--   id_grado_sistema    -> tbl_grados.id                int
--   id_grado_solicitado -> tbl_grados.id                int
-- ============================================================================

CREATE TABLE IF NOT EXISTS tbl_cupos (
    id                  int          NOT NULL AUTO_INCREMENT,
    nombres             varchar(50)  DEFAULT NULL,
    apellidos           varchar(50)  DEFAULT NULL,
    n_documento         varchar(15)  NOT NULL,
    acudiente           varchar(100) DEFAULT NULL,
    telefono_acudiente  varchar(20)  DEFAULT NULL,
    email_acudiente     varchar(50)  DEFAULT NULL,
    id_grado_sistema    int          DEFAULT NULL,
    id_grado_solicitado int          DEFAULT NULL,
    respuesta_pregunta  varchar(2000) DEFAULT NULL,
    fecha_solicitud     date         DEFAULT NULL,
    `año`               int          DEFAULT NULL,
    PRIMARY KEY (id),
    KEY idx_cupos_documento (n_documento),
    KEY idx_cupos_grado_sol (id_grado_solicitado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
