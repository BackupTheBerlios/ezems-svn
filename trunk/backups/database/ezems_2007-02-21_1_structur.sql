# Strukturbackup: 21.02.2007 13:18 

# ----------------------------------------------------------
#
# structur for Table 'ezems_access'
#
CREATE TABLE ezems_access (
    accessSiteId int(7) DEFAULT '0' NOT NULL,
    accessGroupId int(7) DEFAULT '0' NOT NULL,
    accessLevel int(1) DEFAULT '0' NOT NULL,
  PRIMARY KEY (accessGroupId, accessLevel, accessSiteId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_bbcode'
#
CREATE TABLE ezems_bbcode (
    bbcodeId int(7) NOT NULL auto_increment,
    bbcodeName varchar(20),
    bbcodeFile varchar(30),
    bbcodeView int(2),
  PRIMARY KEY (bbcodeId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_captcha'
#
CREATE TABLE ezems_captcha (
    captchaId int(7) NOT NULL auto_increment,
    captchaCode varchar(6),
  PRIMARY KEY (captchaId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_clandb'
#
CREATE TABLE ezems_clandb (
    clanDbId int(7) unsigned NOT NULL auto_increment,
    clanDbName varchar(255) NOT NULL,
    clanDbShortName varchar(50) NOT NULL,
    clanDbTag varchar(50) NOT NULL,
    ClanDbCountry varchar(50) NOT NULL,
    clanDbHomepage varchar(255) NOT NULL,
    clanDbImage varchar(255) NOT NULL,
  PRIMARY KEY (clanDbId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_clanwars'
#
CREATE TABLE ezems_clanwars (
    clanwarsId int(7) unsigned NOT NULL auto_increment,
    clanwarsGameId int(7) DEFAULT '0' NOT NULL,
    clanwarsCategoryId int(7) DEFAULT '0' NOT NULL,
    clanwarsSquadId int(7) DEFAULT '0' NOT NULL,
    clanwarsEnemyId int(7) DEFAULT '0' NOT NULL,
    clanwarsSquadListPlayerId text NOT NULL,
    clanwarsListEnemy text NOT NULL,
    clanwarsDate varchar(20) NOT NULL,
    clanwarsMapsId text NOT NULL,
    clanwarsResults text NOT NULL,
    clanwarsFiles text NOT NULL,
  PRIMARY KEY (clanwarsId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_errors'
#
CREATE TABLE ezems_errors (
    errorsId int(7) NOT NULL auto_increment,
    errorsFile varchar(100),
    errorsMessage varchar(120),
    errorsFatal int(1),
    errorsUserIP varchar(15),
    errorsUserId int(7),
    errorsTimestamp int(11),
  PRIMARY KEY (errorsId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_games'
#
CREATE TABLE ezems_games (
    gamesId int(10) unsigned NOT NULL auto_increment,
    gamesName varchar(255) NOT NULL,
    gamesVersion varchar(50) NOT NULL,
    gamesPublisher varchar(255) NOT NULL,
    gamesWebsite varchar(255) NOT NULL,
    gamesIcon varchar(80) NOT NULL,
  PRIMARY KEY (gamesId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_groups'
#
CREATE TABLE ezems_groups (
    groupsId int(7) NOT NULL auto_increment,
    groupsName varchar(50) NOT NULL,
    groupsWWW varchar(80) NOT NULL,
    groupsInfo text NOT NULL,
    groupsTime int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (groupsId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_icons'
#
CREATE TABLE ezems_icons (
    iconsId int(7) NOT NULL auto_increment,
    iconsPath varchar(20) NOT NULL,
    iconsName varchar(50) NOT NULL,
    iconsAutor varchar(80) NOT NULL,
    iconsWWW varchar(80) NOT NULL,
    iconsInfo text NOT NULL,
    iconsTime int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (iconsId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_languages'
#
CREATE TABLE ezems_languages (
    languagesId int(7) NOT NULL auto_increment,
    languagesPath varchar(20) NOT NULL,
    languagesName varchar(50) NOT NULL,
    languagesAutor varchar(80) NOT NULL,
    languagesWWW varchar(80) NOT NULL,
    languagesInfo text NOT NULL,
    languagesTime int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (languagesId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_maps'
#
CREATE TABLE ezems_maps (
    mapsId int(7) unsigned NOT NULL auto_increment,
    mapsName varchar(255) NOT NULL,
    mapsPic varchar(255) NOT NULL,
    mapsGameId int(7) DEFAULT '0' NOT NULL,
  PRIMARY KEY (mapsId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_player'
#
CREATE TABLE ezems_player (
    playerId int(7) DEFAULT '0' NOT NULL,
    playerSquadId int(7) DEFAULT '0' NOT NULL,
    playerSquadFunction varchar(255) NOT NULL,
    playerUserId int(7) DEFAULT '0' NOT NULL
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_plugins'
#
CREATE TABLE ezems_plugins (
    pluginsId int(7) NOT NULL auto_increment,
    pluginsPath varchar(20) NOT NULL,
    pluginsName varchar(50) NOT NULL,
    pluginsAutor varchar(80) NOT NULL,
    pluginsWWW varchar(80) NOT NULL,
    pluginsInfo text NOT NULL,
    pluginsTime int(11) DEFAULT '0' NOT NULL,
    pluginsInstall longtext NOT NULL,
    pluginsReqPlugins varchar(255) NOT NULL,
    pluginsReqTables varchar(255) NOT NULL,
  PRIMARY KEY (pluginsId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_settings'
#
CREATE TABLE ezems_settings (
    settingsId int(7) NOT NULL auto_increment,
    settingsPlugin varchar(20) NOT NULL,
    settingsKey varchar(30) NOT NULL,
    settingsValue varchar(80) NOT NULL,
  PRIMARY KEY (settingsId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_sites'
#
CREATE TABLE ezems_sites (
    sitesId int(7) NOT NULL auto_increment,
    sitesPluginId int(7),
    sitesName varchar(20),
    sitesTyp int(1),
  PRIMARY KEY (sitesId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_squads'
#
CREATE TABLE ezems_squads (
    squadsId int(7) unsigned NOT NULL auto_increment,
    squadsGameId int(7) DEFAULT '0' NOT NULL,
    squadsName varchar(255) NOT NULL,
    squadsTag varchar(255) NOT NULL,
    squadsPic varchar(255) NOT NULL,
  PRIMARY KEY (squadsId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_stats'
#
CREATE TABLE ezems_stats (
    statsId int(11) NOT NULL auto_increment,
    statsIP varchar(15),
    statsReferer varchar(80),
    statsBrowser int(2),
    statsTime int(11),
    statsUriPlug varchar(15),
    statsUriSite varchar(15),
  PRIMARY KEY (statsId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_templates'
#
CREATE TABLE ezems_templates (
    templatesId int(7) NOT NULL auto_increment,
    templatesPath varchar(20) NOT NULL,
    templatesName varchar(50) NOT NULL,
    templatesAutor varchar(80) NOT NULL,
    templatesWWW varchar(80) NOT NULL,
    templatesInfo text NOT NULL,
    templatesTime int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (templatesId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_themes'
#
CREATE TABLE ezems_themes (
    themesId int(7) NOT NULL auto_increment,
    themesPath varchar(20) NOT NULL,
    themesName varchar(50) NOT NULL,
    themesAutor varchar(80) NOT NULL,
    themesWWW varchar(80) NOT NULL,
    themesInfo text NOT NULL,
    themesTime int(11) DEFAULT '0' NOT NULL,
  PRIMARY KEY (themesId)
);


# ----------------------------------------------------------
#
# structur for Table 'ezems_users'
#
CREATE TABLE ezems_users (
    usersId int(7) NOT NULL auto_increment,
    usersUsername varchar(80),
    usersPassword varchar(80),
    usersThemeId int(7),
    usersTemplateId int(7),
    usersIconId int(7),
    usersLanguageId int(7),
    usersGroupId int(7),
    usersLastOnline int(11),
    usersGhostOnline int(1),
    usersFirstname varchar(80),
    usersLastname varchar(80),
    usersEmail varchar(80),
    usersTime int(11),
  PRIMARY KEY (usersId)
);

