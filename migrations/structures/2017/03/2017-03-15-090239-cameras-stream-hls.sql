ALTER TABLE cameras ADD stream_hls TEXT NOT NULL DEFAULT '';
ALTER TABLE cameras ALTER stream_hls DROP DEFAULT;
