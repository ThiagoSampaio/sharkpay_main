om the leading edge of the RenderViewport
    // to the zero scroll offset (the line between the forward slivers and the
    // reverse slivers).
    final double centerOffset = mainAxisExtent * anchor - correctedOffset;
    final double reverseDirectionRemainingPaintExtent = clampDouble(
      centerOffset,
      0.0,
      mainAxisExtent,
    );
    final double forwardDirectionRemainingPaintExtent = clampDouble(
      mainAxisExtent - centerOffset,
      0.0,
      mainAxisExtent,
    );

    _calculatedCacheExtent = switch (cacheExtentStyle) {
      CacheExtentStyle.pixel => cacheExtent,
      CacheExtentStyle.viewport => mainAxisExtent * _cacheExtent,
    };

    final double fullCacheExtent = mainAxisExtent + 2 * _calculatedCacheExtent!;
    final double centerCacheOffset = centerOffset + _calculatedCacheExtent!;
    final double reverseDirectionRemainingCacheExtent = clampDouble(
      centerCacheOffset,
      0.0,
      fullCacheExtent,
    );
    final double forwardDirectionRema