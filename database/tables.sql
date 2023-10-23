DROP TABLE IF EXISTS "subscribers";
CREATE TABLE "subscribers" (
	"id" integer PRIMARY KEY autoincrement NOT NULL,
	"name" varchar NOT NULL,
	"email" varchar NOT NULL,
	"password" varchar NOT NULL,
	"created_at" datetime,
	"updated_at" datetime
);

DROP TABLE IF EXISTS "music_boxes";
CREATE TABLE "music_boxes" (
	"id" integer PRIMARY KEY autoincrement NOT NULL,
	"prayer_timezone" varchar NOT NULL,
	"prayer_time_enabled" tinyint (1) NOT NULL DEFAULT '1',
	"created_at" datetime,
	"updated_at" datetime
);

DROP TABLE IF EXISTS "songs";
CREATE TABLE "songs" (
	"id" integer PRIMARY KEY autoincrement NOT NULL,
	"music_box_id" integer NOT NULL,
	"name" varchar NOT NULL,
	"filepath" varchar NOT NULL,
	"created_at" datetime,
	"updated_at" datetime
);

DROP TABLE IF EXISTS "prayer_times";
CREATE TABLE "prayer_times" (
	"id" integer PRIMARY KEY autoincrement NOT NULL,
	"prayer_timezone" varchar NOT NULL,
	"waktu" varchar NOT NULL,
	"start_at" datetime,
	"created_at" datetime,
	"updated_at" datetime
);

DROP TABLE IF EXISTS "subscriptions";
CREATE TABLE "subscriptions" (
	"id" integer PRIMARY KEY autoincrement NOT NULL,
	"subscriber_id" integer NOT NULL,
	"music_box_id" integer NOT NULL,
	"created_at" datetime,
	"updated_at" datetime
);
