
DELIMITER //

CREATE TRIGGER `after_update_passage` 
AFTER UPDATE ON `passages` FOR EACH ROW 
BEGIN IF NEW.plate <> OLD.plate THEN UPDATE securos_websocket sw 
SET sw.new_number = NEW.plate WHERE sw.uuid=OLD.external_id; END IF; 
IF NEW.container <> OLD.container THEN UPDATE securos_websocket sw 
SET sw.new_number = NEW.container WHERE sw.uuid = OLD.external_id; 
END IF; END;

DELIMITER ;