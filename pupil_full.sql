DROP VIEW pupil_full;
CREATE VIEW pupil_full 
AS
SELECT pupil.full_name,pupil.sex,DATE_FORMAT(pupil.birthday,'%d/%m/%Y') as birthday,class.name,pupil.id,pupil.married,pupil.introduce,pupil.avatar,pupil.profile,pupil.class_id from pupil join class on class.id=pupil.class_id 