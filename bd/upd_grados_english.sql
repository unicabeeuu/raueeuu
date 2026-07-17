/* ============================================================================
   Migración: grados de tbl_grados al sistema US (nombres en inglés)
   - Renombra los grados existentes conservando el id.
   - El id pasa a coincidir con el número de grado US: id 9 = 9th grade,
     id 12 = 12th grade. Los ciclos (13-18) pasan a Cycle I-VI.
   - Inserta la fila id 0 = 'No degree' (requiere NO_AUTO_VALUE_ON_ZERO).
   Ejecutar una sola vez sobre la BD admin_unieeuu.
   ============================================================================ */

SET SQL_SAFE_UPDATES = 0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

UPDATE tbl_grados SET grado = '1st grade'  WHERE id = 1;  /* antes: Sin grado */
UPDATE tbl_grados SET grado = '2nd grade'  WHERE id = 2;  /* antes: Primero   */
UPDATE tbl_grados SET grado = '3rd grade'  WHERE id = 3;  /* antes: Segundo   */
UPDATE tbl_grados SET grado = '4th grade'  WHERE id = 4;  /* antes: Tercero   */
UPDATE tbl_grados SET grado = '5th grade'  WHERE id = 5;  /* antes: Cuarto    */
UPDATE tbl_grados SET grado = '6th grade'  WHERE id = 6;  /* antes: Quinto    */
UPDATE tbl_grados SET grado = '7th grade'  WHERE id = 7;  /* antes: Sexto     */
UPDATE tbl_grados SET grado = '8th grade'  WHERE id = 8;  /* antes: Séptimo   */
UPDATE tbl_grados SET grado = '9th grade'  WHERE id = 9;  /* antes: Octavo    */
UPDATE tbl_grados SET grado = '10th grade' WHERE id = 10; /* antes: Noveno    */
UPDATE tbl_grados SET grado = '11th grade' WHERE id = 11; /* antes: Décimo    */
UPDATE tbl_grados SET grado = '12th grade' WHERE id = 12; /* antes: UnDécimo  */
UPDATE tbl_grados SET grado = 'Cycle I'    WHERE id = 13; /* antes: Ciclo I   */
UPDATE tbl_grados SET grado = 'Cycle II'   WHERE id = 14; /* antes: Ciclo II  */
UPDATE tbl_grados SET grado = 'Cycle III'  WHERE id = 15; /* antes: Ciclo III */
UPDATE tbl_grados SET grado = 'Cycle IV'   WHERE id = 16; /* antes: Ciclo IV  */
UPDATE tbl_grados SET grado = 'Cycle V'    WHERE id = 17; /* antes: Ciclo V   */
UPDATE tbl_grados SET grado = 'Cycle VI'   WHERE id = 18; /* antes: Ciclo VI  */

INSERT INTO tbl_grados (id, grado)
SELECT 0, 'No degree'
WHERE NOT EXISTS (SELECT 1 FROM tbl_grados WHERE id = 0);
