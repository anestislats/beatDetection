clear;
clc;

dir = 'music\';
fileID = fopen('textfiles\TrackName.txt');
trackname = fgetl(fileID);
fclose(fileID);


track =[dir trackname ];
[audio fr] = audioread(track);

arraysize = size(audio);

% If audio file is more than 30 seconds create a 20 second file's sample
rows = arraysize(1);

a = audioinfo(track);
seconds = a.Duration;

if seconds > 30
    startrows = fr*60 %60th second
    endrows = startrows + fr*20 %20 seconds after 1st minute
    final_audio = audio(startrows:endrows,1:end); %20 seconds sample after 1st minute
else
    final_audio = audio;
end


filter = filterbank(final_audio);
smoothing = hwindow(filter);
diffr = diffrect(smoothing);

bpm = timecomb(diffr);


fid = fopen( 'textfiles\results.txt', 'wt' );
  fprintf( fid, '%f', bpm);
fclose(fid);

quit force
