CREATE VIEW pupil_full
AS
SELECT pupil.full_name,pupil.sex,pupil.birthday,class.name,pupil.id,pupil.married,pupil.introduce,pupil.avatar,pupil.profile,pupil.class_id from pupil join class on class.id=pupil.class_id