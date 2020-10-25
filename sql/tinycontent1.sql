#
# Table structure for table `tinycontent`
#

CREATE TABLE tinycontent1 (
    storyid       INT(8)          NOT NULL AUTO_INCREMENT,
    blockid       INT(8) UNSIGNED NOT NULL DEFAULT '0',
    title         VARCHAR(255)    NOT NULL DEFAULT '',
    text          TEXT                     DEFAULT NULL,
    visible       TINYINT(1)      NOT NULL DEFAULT '0',
    homepage      TINYINT(1)      NOT NULL DEFAULT '0',
    nohtml        TINYINT(1)      NOT NULL DEFAULT '0',
    nosmiley      TINYINT(1)      NOT NULL DEFAULT '0',
    nobreaks      TINYINT(1)      NOT NULL DEFAULT '0',
    nocomments    TINYINT(1)      NOT NULL DEFAULT '0',
    link          TINYINT(1)      NOT NULL DEFAULT '0',
    address       VARCHAR(255)             DEFAULT NULL,
    submenu       TINYINT(1)      NOT NULL DEFAULT '0',
    last_modified TIMESTAMP(14),
    created       DATETIME        NOT NULL DEFAULT '2001-1-1 00:00:00',
    html_header   TEXT                     DEFAULT NULL,

    KEY (title),
    KEY (blockid),
    KEY (visible),
    KEY (homepage),
    KEY (nohtml),
    KEY (nosmiley),
    KEY (nobreaks),
    KEY (nocomments),
    KEY (link),
    KEY (address),
    KEY (submenu),
    KEY (last_modified),
    PRIMARY KEY (storyid)
)
    ENGINE = ISAM;
